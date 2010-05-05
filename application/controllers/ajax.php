<?php
class Ajax_Controller extends Controller{

    public function __construct(){
        parent::__construct();
        if(strpos(url::current(), 'set')!== FALSE){
            $cache = Cache::instance();
            $cache->delete_tag('dir_trees');
            $cache->delete_tag('cd_rows');

        }
    }

    public function set_tag(){
        $imgs = $this->input->post('data');
        if(!$imgs) return;        
        $tag = $this->input->post('tag');
        if(!$tag) return;
        
        $imgs  = str_replace('image-', '', $imgs);
        $imgs = explode('|',$imgs);
        $tags = new Tags_Model();
        if(strpos($tag, 'cc-')!==FALSE){ // we want to copy tags from another image
            $image_tag = new ImageTag_Model();
            $c = str_replace('cc-', '', $tag);            
            $image_tag->addFilter('image_id',$c );
            $tids = $image_tag->fetch();
            $rimgs = array();
            foreach($tids as $tid){
                $rimgs  = array_merge($rimgs,$tags->add_to_images($tid->tag_id, $imgs));
            }
            $imgs = $rimgs;
        } else{
            $tag_id = str_replace('tag-','',$tag);            
            $imgs = $tags->add_to_images($tag_id, $imgs);
        }        
        echo json_encode($tags->getImagesTags($imgs));
    }

     public function set_video_tag(){
        $vids= $this->input->post('data');
        if(!$vids) return;
        $tag = $this->input->post('tag');
        if(!$tag) return;

        $tags = new Tags_Model();
        $vids  = str_replace('video-', '', $vids);
        $vids = explode('|',$vids);
        

        if(strpos($tag, 'cc-')!==FALSE){ // we want to copy tags from another image
            $video_tag = new VideoTag_Model();
            $c = str_replace('cc-', '', $tag);
            $video_tag->addFilter('video_id',$c );
            $tids = $video_tag->fetch();
            $rimgs = array();
            foreach($tids as $tid){
                $rimgs  = array_merge($rimgs,$tags->add_to_videas($tid->tag_id, $vids));
            }
            $vids = $rimgs;
        } else{
            $tag_id = str_replace('tag-','',$tag);
            $vids = $tags->add_to_videas($tag_id, $vids);
        }        
        
        echo json_encode($tags->getVideoTags($vids));
    }

    public function set_tag_dir(){
        $tag_id = $this->input->post('tag');
        $dir_id = $this->input->post('dir_id');
        $def_dir = $this->input->post('default_dir');
        if(!$tag_id || !$dir_id) return;
        
        $dir_id = str_replace('dir-','',$dir_id);
        $def_dir = str_replace('dir-','',$def_dir);

        $tags = new Tags_Model();
        
        if(strpos($tag_id, 'cc-')!==FALSE){ // we want to copy tags from another image
            $image_tag = new ImageTag_Model();
            $c = str_replace('cc-', '', $tag_id);
            $image_tag->addFilter('image_id',$c );
            $tids = $image_tag->fetch();
            $res = array();
            foreach($tids as $tid){
                $res  = array_merge($res,$tags->add_to_dir($tid->tag_id, $dir_id,true));
            }          
        } else {
            $tag_id = str_replace('tag-','',$tag_id);
            $res = $tags->add_to_dir($tag_id, $dir_id, true);
        }
        echo json_encode($tags->getImagesTags($res));       
    }

     public function set_video_tag_dir(){
        $tag_id = $this->input->post('tag');
        $dir_id = $this->input->post('dir_id');
        $def_dir = $this->input->post('default_dir');
        if(!$tag_id || !$dir_id) return;        
        $dir_id = str_replace('dir-','',$dir_id);
        $def_dir = str_replace('dir-','',$def_dir);
        $tags = new Tags_Model();

        if(strpos($tag_id, 'cc-')!==FALSE){ // we want to copy tags from another image
            $video_tag = new VideoTag_Model();
            $c = str_replace('cc-', '', $tag_id);
            $video_tag->addFilter('video_id',$c );
            $tids = $video_tag->fetch();
            $res = array();
            foreach($tids as $tid){
                $res  = array_merge($res,$tags->add_to_dir($tid->tag_id, $dir_id,true,true));
            }
        } else {
            $tag_id = str_replace('tag-','',$tag_id);
            $res = $tags->add_to_dir($tag_id, $dir_id, true,true);
        }

        echo json_encode($tags->getVideoTags($res));
    }

    public function get_cd_tags(){

        $cd_id = $this->input->post('cd_id');
        if(!$cd_id) return;
        $cd = new Cd_Model();
        $cd_row = $cd->get($cd_id);
        if(!$cd_row) return;
        echo $cd_row['tags'];

    }

      public function get_video_cd_tags(){

        $cd_id = $this->input->post('cd_id');
        if(!$cd_id) return;
        $vid = new Video_Model();
        $cd_row = $vid->getCdRow($cd_id);
        if(!$cd_row) return;
        echo $cd_row['tags'];

    }

    public function get_dir_tags($what='images'){
        $cd = new Cd_Model();
        $cd_id = $this->input->post('cd_id');
        $dir_id = $this->input->post('dir_id');        
        echo View::factory('cd/tags')->set('tags',$cd->getTags($cd_id,$dir_id))->set('dir_id',$dir_id)->render();
    }

      public function get_video_dir_tags(){
        $cd = new Cd_Model();
        $cd_id = $this->input->post('cd_id');
        $dir_id = $this->input->post('dir_id');
        echo View::factory('cd/tags')->set('tags',$cd->getTags($cd_id,$dir_id,'video'))->set('dir_id',$dir_id)->set('video',true)->render();
    }

    public function searchTags(){
        $t = new Table_Model('tag');
        $q = $_GET['q'];
        $t->limit = array('offset'=>0,'count'=>$_GET['limit']);
        $lang = Session::instance()->get('lang');
        $t->apply_search($q,'lower(name'.$lang.')','%s%%');
        //$r = new $tags
        echo View::factory('tags/plain')->set('tags',$t->fetch())->render();
    }
    
    public function getVideoImage(){
        $vid = $this->input->post('id');
        $src = $this->input->post('src');
        if(!$vid || !$src) return ;
        $v = new Video_Model();
        $p = pathinfo($src);
        $i = intval(substr($p['filename'],- Kohana::config('videoconversion.pad_count')));
        $i++;
        if(count(Kohana::config('videoconversion.thumbnails'))-1< $i) $i=0;
        echo json_encode(array('src'=>$v->getThumb($vid, $i),'id'=>$vid));
    }

    public function getBigThumb($image_id,$orientation){
        $image_model  = new Images_Model();
        $row = $image_model->get($image_id);
       //if(!$row) return ;
        $img = new Image($image_model->filename($row));
        $img->quality(75);
        if($orientation=='p')$img->resize(480, 640, IMAGE::NONE);
        else $img->resize(640,480,IMAGE::NONE);
        $img->render();

    }

    public function getState(){
        $this->cache = Cache::instance();
        $what = $this->input->post('what');        
        echo View::factory('admin/previewState')->set(sharedState::get($what))->render();
    }

    public function generatePreviewImages(){        
        $img = new Images_Model();
        if(!sharedState::get('generatePreviewImages'))  $img->generate_previews();
    }

    public function encodeImages(){
        $img = new Images_Model();
         if(!sharedState::get('encodeImages')) $img->encode_images();
    }

    public function decodeImages(){
        $img = new Images_Model();
         if(!sharedState::get('decodeImages')) $img->decode_images();
    }

     public function watermarkImages(){
        ini_set('gd.jpeg_ignore_warning', 1);
        $img = new Images_Model();
         if(!sharedState::get('watermarkImages')) $img->watermark_images();
    }

  public function checkDatabase(){
        $img = new Images_Model();
        if(!sharedState::get('checkDatabase'))  $img->checkFilesExistence(); 
    }

    public function getContainers(){
        $c = new Container_Model();
        $conts = $c->fetch();
        $res = array();
        foreach($conts as $cont){
            $res[$cont->code] = $cont->cont_name_en;
        }
        echo json_encode($res);
    }

    public function storeCdInDatabase($name,$container){
        $dir = Kohana::config('catalogue.directory').'/'.$name;
        $alias = substr($name, 3);
        
        $cd  = new Cd_Model();
        $res = $cd->getPlain($dir,'directory');
        if($res!==false) {echo json_encode(array('result'=>false));return;}
        $cont = new Container_Model();
        $c = $cont->get($container, 'cont_name_en');
        $cdData = array('alias'=>$alias,'directory'=>$dir,'container_id'=>$c['container_id']);        
        echo "OK: ".$cd->add($cdData);
        //TODO: dodelat , container a ostatni vopicarny, zjistit adresar}
    }



    public function toggleEditting(){
        $ses = Session::instance();
        $val = $ses->get('tag_editing','false');
        $ses->set('tag_editing',($val == 'false')? 'true' : 'false');
    }

}
?>
