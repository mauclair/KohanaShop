<?php
//		sets video & thumbnail dimensions
//	!	one of the video parameters must be -3 in order to get the side counted up	!
define("VIDEO_WIDTH","150");
#define("VIDEO_WIDTH","512");
define("VIDEO_HEIGHT","-3");
#define("VIDEO_HEIGHT","384");
define("THUMB_WIDTH","80");
define("THUMB_HEIGHT","");

/**
 * VideoConversion class
 *
 */

/**
 * VideoConversion class. Provides methods for video conversion.
 * @package perfektcams
 * @subpackage extra
 */

class VideoConversion_Core
{
	/**
	 * app for conversion
	 *
	 * @var string
	 */
	private $appConvert;
	/**
	 * app for fixing metadata
	 *
	 * @var string
	 */
	private $appFix;
	/**
	 * app for creating thumbnails
	 *
	 * @var string
	 */
	private $appThumb;
	/**
	 * actual timestamp
	 *
	 * @var int
	 */
	private $timestamp;
	/**
	 * input folder
	 *
	 * @var string
	 */
	private $inDir;

	/**
	 * input filename
	 *
	 * @var string
	 */
	private $input;
	/**
	 * output filename
	 *
	 * @var string
	 */
	private $output;
	/**
	 * semi-output name
	 *
	 * @var string
	 */
	private $outName;
	/**
	 * output folder
	 *
	 * @var string
	 */
	private $outDir;
	/**
	 * length of output file
	 *
	 * @var string
	 */
	private $outLength;
	/**
	 * thumbnail filename
	 *
	 * @var string
	 */
	private $thumbName;
	/**
	 * thumbnail folder
	 *
	 * @var string
	 */
	private $thumbDir;
	/**
	 * error
	 *
	 * @var array
	 */
	private $error;

	/*--------------------------------------------------------------------------*/
	public function __construct()
	{
		//	essential settings
		$this->appConvert = Kohana::config('videoconversion.application_convert');
		$this->appFix = Kohana::config('videoconversion.application_fix');;
		$this->appThumb = Kohana::config('videoconversion.application_thumbnail');;
		$this->timestamp = time();
	}

	/*--------------------------------------------------------------------------/$input, $output, $outDir, $thumbDir*/
	/**
	 * Converts input file, calls needed methods for fixing, creating thumbnails
	 *
	 * @param array $params conversion parameters
	 * @return array result of conversion and length of video
	 */
	public function Convert($params)
	{
		//essential settings
		$this->input = $params['input'];
		$this->inDir = $params['in_dir'];
		$this->outDir = $params['out_dir'];
		$this->thumbDir = $params['out_dir'];
		$this->outName = $params['output'].".flv";
		$this->output = $params['output'];

		//convert flv to avi first
		if($params['extension'] == '.flv')
		{
			$cmdThumb = $this->appThumb." -y -i ".$this->input." -sameq -vcodec mpeg1video ".$this->input.'_ffmpeg.avi';
			exec($cmdThumb, $thumbnail);

			//delete input
			@unlink($this->input);

			//set converted file as new input
			$this->input .= '_ffmpeg.avi';
		}

		//resize, resample, convert to flv
		if(!is_file($this->inDir.$this->outName))
		{
			$cmdConvert = $this->appConvert." ".$this->input." -o ".$this->inDir.$this->outName." -of lavf  -nosound -ovc lavc -lavcopts vcodec=flv:mbd=2:trell:v4mv:cbp:last_pred=3 -lavfopts format=flv  -vf scale=".Kohana::config('videoconversion.width').":".Kohana::config('videoconversion.height')." -quiet";
			exec($cmdConvert, $conversion);

			//echo '<pre>';
			//echo 'cmdThumb: ';
			//echo $cmdThumb.'<br/>';
			//echo 'thumbnail: ';
			//print_r($thumbnail);
			//echo 'cmdConvert: ';
			//echo $cmdConvert.'<br/>';
			//echo 'conversion: ';
			print_r($conversion);

			#seek for number of frames in video + audio stream
			for($i = sizeof($conversion); $i >= 0; $i--)
			{
				if(preg_match("/bytes  ([0-9\.]*?) secs  ([0-9]*?) frames/", $conversion[$i], $video_info))
					break;
			}

			for($i = sizeof($conversion); $i >= 0; $i--)
			{
				if(preg_match("/bytes  ([0-9\.]*?) secs/", $conversion[$i], $audio_info))
					break;
			}

			//echo 'videoinfo: ';
			//print_r($video_info);
			//echo 'audioinfo: ';
			//print_r($audio_info);
		}

		//output file exist, conversion was successful
		if(is_file($this->inDir.$this->outName))
		{
			if(!empty($video_info))
			{
				if($video_info[1] >= $audio_info[1])
				{
					$clip_frames = floor($video_info[2] / $video_info[1] * $audio_info[1]);
				}
				else
				{
					$clip_frames = floor($video_info[2] / $audio_info[1] * $video_info[1]);
				}
			}

			//fix flv and create thumbnail (dont test result, its done later by checking this->error)
			$this->Fix($clip_frames) && $this->Thumbnail();

		}
		//conversion error
		else
		{
			$this->error[] = array("Convert(): Error converting video: ".$this->outName."\n", 101);
		}

		if(empty($this->error))
		{
			$return = array(
				'result'=> true,
				'length' => $this->outLength
				);
		}
		else
		{
			$return = array(
				'result'=> false,
				'length' => $this->outLength
				);
		}

		//clear input/temporary files
		$this->Clean(true);

		//echo 'error: ';
		//print_r($this->error);
		//die();
		return $return;
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Fixes metadata of FLV file
	 *
	 * @param int $clip_frames (optional)
	 * @return bool
	 */
	private function Fix($clip_frames = '')
	{

		$clip_frames -= $clip_frames % 10;

		//fixes meta data of FLV movie
		if($clip_frames)
		{
			$cmdFix = $this->appFix." -CUPvk -i 0 -o ".($clip_frames/25*1000)." ".$this->inDir.$this->outName." ".$this->outDir.$this->outName;
		}
		else
		{
			$cmdFix = $this->appFix." -CUPvk -i 0 ".$this->inDir.$this->outName." ".$this->outDir.$this->outName;
		}

		if(is_file($this->inDir.$this->outName))
		{
			exec($cmdFix, $fixing);
			//echo 'cmdFix: ';
			//echo $cmdFix.'<br/>';
			//echo 'fixing: ';
			//print_r($fixing);

			if(!empty($fixing))
			{
				//	gets length of movie
				for($i = 0; $i < count($fixing); $i++)
				{
					if(substr(ltrim($fixing[$i]), 0, 8) == "duration")
					{
						//	crops the string and gets only length of movie
						$this->outLength =  substr(strrchr($fixing[$i], ":"), 2);
					}
				}

				if(!$this->outLength) $this->error[] = array("Fix(): Error getting movie length: temp/".$this->outName."\n", 206);

				//	cleaning
#				unlink($this->inDir.$this->outName);
				return true;
			}
			else
			{
				$this->error[] = array("Fix(): Error fixing video: ".$this->inDir.$this->outName."\n", 102);
				return false;
			}
		}
		else
		{
			$this->error[] = array("Fix(): Error fixing video: ".$this->inDir.$this->outName."\n", 102);
			return false;
		}

	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Creates thumbnail from video file
	 *
	 * @return bool
	 */
	private function Thumbnail()
	{
		//sets time of taking screen in order to create thumbnail
		$shootTime = 5;
		if($this->Length < $shootTime)
			$shootTime = 1;

		//	creates thumbnail from generated FLV movie
		$cmdThumb = $this->appThumb." -i ".$this->outDir.$this->outName." -an -ss 00:00:0".$shootTime." -an -r 1 -vframes 1 -y ".$this->outDir."/%d.jpg";
		exec($cmdThumb, $thumbnail);
		//echo 'cmdThumb: ';
		//echo $cmdThumb.'<br/>';
		//echo 'thumbnail: ';
		//print_r($thumbnail);		//	cleaning

		if(is_file($this->outDir."/1.jpg"))
		{
			//renames to final name (mediaId.jpg)
			$this->thumbName = $this->output.".jpg";
			rename($this->outDir."/1.jpg", $this->thumbName);
			return true;
		}
		else
		{
			$this->error[] = array("Thumbnail(): Error creating thumbnail: ".$this->outDir.$this->outName."\n", 103);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Returns length of video
	 *
	 * @return mixed
	 */
	public function GetLength()
	{
		//	returns value got from Fix();
		if($this->outLength)
		{
			return $this->outLength;
		} else {
			return 0;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Gets video dimensions
	 *
	 * @return mixed
	 */
	public function GetVideoDimensions()
	{
		//	gets dimensions of thumb/movie
		if(is_null($videoSize = @getimagesize($this->thumbDir.$this->thumbName)) == 0)
		{
			return $videoSize;
		} else {
			$this->error[] = array("GetVideoDimensions(): Error getting dimensions of ".$this->thumbDir.$this->thumbName."\n", 204);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Gets dimensions of thumbnail
	 *
	 * @return mixed
	 */
	public function GetThumbDimensions()
	{
		$videoSize = $this->GetVideoDimensions();
		if(!empty($videoSize))
		{
			//	count the other side, depends on which one of proportions is set
			if(THUMB_WIDTH != "")
			{
				$thumbSize = array(THUMB_WIDTH, ceil(($videoSize[1]/$videoSize[0])*THUMB_WIDTH));
			} elseif(THUMB_HEIGHT != "") {
				$thumbSize = array(ceil(($videoSize[0]/$videoSize[1])*THUMB_HEIGHT), THUMB_HEIGHT);
			} else {
				$this->error[] = array("GetThumbDimensions(): Error getting dimensions of ".$this->thumbDir.$this->thumbName."\n", 204);
				return false;
			}
			return $thumbSize;
		} else {
			$this->error[] = array("GetThumbDimensions(): Error getting dimensions of ".$this->thumbDir.$this->thumbName."\n", 204);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Returns movie src
	 *
	 * @return mixed
	 */
	public function GetVideoSrc()
	{
		//	gets name of movie file
		if($videoSrc = $this->outDir.$this->outName)
		{
			return $videoSrc;
		} else {
			$this->error[] = array("GetVideoSrc(): Error getting src of video: ".$this->outDir.$this->outName."\n", 201);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Returns thumbnail src
	 *
	 * @return mixed
	 */
	public function GetThumbSrc()
	{
		//	gets name of thumb file
		if($thumbSrc = $this->thumbDir.$this->thumbName)
		{
			return $thumbSrc;
		}
		else
		{
			$this->error[] = array("GetThumbSrc(): Error getting src of thumb: ".$this->thumbDir.$this->thumbName."\n", 202);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Gets size of converted video file
	 *
	 * @return mixed
	 */
	public function GetFileSize()
	{
		//	gets size of movie (in bytes)
		if(is_null($fileSize = @filesize($this->outDir.$this->outName)) == 0)
		{
			return $fileSize;
		}
		else
		{
			$this->error[] = array("GetFileSize(): Error getting filesize of file: ".$this->outDir.$this->outName."\n", 203);
			return false;
		}
	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Uploads movie to input folder
	 *
	 * @return bool
	 */
	public function UploadFile()
	{
		//	uploads movie to inDir
		$this->input = $this->timestamp."_".$this->input['name'];
		if($upload = move_uploaded_file($this->input['tmp_name'], $this->inDir.$this->input['name']))
		{
			return true;
		}
		else
		{
			$this->error[] = array("UploadFile(): Error uploading file: ".$this->input['tmp_name']." to ".$this->inDir.$this->input['name']."\n", 100);
			return false;
		}

	}

	/*--------------------------------------------------------------------------*/
	/**
	 * Clears temp & not fixed files if set
	 *
	 * @param bool $bool flag
	 * @return void
	 */
	public function Clean($bool)
	{
		if($bool == true)
		{
			#delete input file
			@unlink($this->input);

			#delete tmp (input flv to tmp avi)


			#delete not fixed file
			@unlink($this->inDir.$this->outName);
		}
	}

}

?>