<?php
class ImageGps_Model extends Model{
    public function __construct() {
        parent::__construct();

    }

    public static function getString($filename,$decimal=false){
        try{
            $exif = @exif_read_data($filename, 0, false);
        } catch(Exception $e){
            return 'false';
        }
        if(!$exif) return 'false'; // no exif stop parsing
        if(
            !isset($exif['GPSLatitude']) ||
            !isset($exif['GPSLatitudeRef']) ||
            !isset($exif['GPSLongitude']) ||
            !isset($exif['GPSLongitudeRef'])            

        ) return 'false';
        $lat = $exif['GPSLatitude'];
        $lng = $exif['GPSLongitude'];
        $latRef = $exif['GPSLatitudeRef'];
        $lngRef = $exif['GPSLongitudeRef'];

        // get rid of the / in number
        foreach($lat as $k=>$v){
            $a = explode('/',$v);
            if(count($a)>1 && $a[1]>0) $lat[$k] = $a[0] / $a[1];            
        }        
        foreach($lng as $k=>$v){
            $a = explode('/',$v);
            if(count($a)>1 && $a[1]>0) $lng[$k] = $a[0] / $a[1];
        }

        if(!$decimal) {
            $res = "$latRef {$lat[0]}°{$lat[1]}'{$lat[2]} $lngRef {$lng[0]}°{$lng[1]}'{$lng[2]}";
        } else {
            $reslat = $lat[0] + $lat[1] / 60 + $lat[2] / 3600;
            if($latRef == 'S') $reslat = -$reslat;
            $reslng = $lng[0] + $lng[1] / 60 + $lng[2] / 3600;
            if($lngRef == 'W') $reslng = -$reslng;
            $res = "$reslat $reslng";
        }
        return $res;




    }

}

?>
