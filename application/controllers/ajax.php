<?php
class Ajax_Controller extends Controller{

    public function uploadGirlImage(){
        $gim = new GirlImage_Model();
        $gim->add($this->input->post());
        echo 'true';
    }

    public function uploadImages(){
        $g = new Girls_Model();
        $g->validation = array();
        $d= $this->input->post();
        $g->update($d);
        echo json_encode($d);
    }

    public function uploadBanner(){
        $ban = new Banner_Model();
        $d = $this->input->post();
        $ban->update($d);
        echo 'true';
    }

    public function uploadTempBanner(){
        $ban = new Banner_Model();
        $d = array('banner_file'=>''); // set fake banner - not exists
        $ban->processFiles($d); // now make fake update, the uploaded file will be processed and resulting filename stored in $d[banner_file]
        $cache = Cache::instance();

        $file_id = 'tempBannerFile'.Session::instance()->id();
        $old_file = $cache->get($file_id);
        if($old_file && file_exists($old_file)) @unlink($old_file);
        $cache->set($file_id,$d['banner_file']);
        $d['file_id'] = $file_id;
        echo json_encode($d);
    }

    public function renderTempBanner(){
       // $file = Session::instance()->get('tempBannerFile');
        $data = $this->input->post();
        echo View::factory('banner_item')->set($data)->set('banner_id',-1)->render();
        
    }

}
?>
