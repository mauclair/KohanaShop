<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of girlImage
 *
 * @author snoblucha
 */
class Image_Model extends Table_Model {
    public $table = 'image';
    public $id = 'image_id';
    public $validation  = array('vymol_id'=>'required');    
    public $files = array('image_file'=>array('directory'=>'upload/images','validation'=>array('upload::type[jpeg,gif,png,jpg]', 'upload::required'),'process'=>array('Image_Model','makePreview')));

    public static function makePreview($filename,$right=false){
        $img = new Image($filename);
        $w = $img->width;
        $h = $img->height;
        $width = Kohana::config('main.image-width');
        if($w  <  $h ){
            // width is smaller - > shrink to width and then crop
            $img->resize($width, $width, Image::WIDTH);
            $img->crop($width,$width,'top');

        } else {
            $img->resize($width, $width, Image::HEIGHT);
            $pos = ($right) ?  'right' : 'left' ;
            $img->crop($width,$width,null,$pos);
        }
        
        $filename = str_replace('upload/images', 'upload/thumbs', $filename);
        Kohana::log('error',$filename);
        $img->save($filename,false);
    }

    public function regenerateThumbs($girl_id){
        $this->where->where('vymol_id', $girl_id);
        $imgs = $this->fetch();
        foreach($imgs as $img){
            $this->makePreview($img->image_file);
        }
    }

    public function deleteImages($vymol_id){
        $this->where->where('vymol_id', $vymol_id);
        $imgs =  $this->fetch();
        foreach($imgs as $img){
            $this->delete($img->image_id);
        }
    }

    public function delete($id){
        $i = $this->get($id);
        //if(file_exists($i['image_file'])) unlink($i['image_file']);
        if(file_exists('upload/thumbs/'.$i['image_file'])) @unlink('upload/thumbs/'.$i['image_file']);
        parent::delete($id);
    }
    /**
     *  Stores image positions due to array
     * @param int $girl_is
     * @param array $images_id
     */
    public function storeImagePositions($girl_is,$images_id){
        $i  = 0;
        $tm = new Table_Model($this->table);
        foreach($images_id as $image_id){
            $image_id = (int)substr($image_id, 4);
            $d = array('image_id'=>$image_id,'position'=>$i);
            $tm->update($d);
            $i++;
        }
    }

    public function add(&$d){
        $d['image_created'] = date('Y-m-d H:i:s');
        parent::add($d);
    }
}
?>
