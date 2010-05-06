<?php
class Banner_Controller extends Controller{
    public function click($banner_id){
        $bm = new Banner_Model();
        $b = $bm->get($banner_id);
        if(!$b) url::redirect(''); else {
            $bm->handleClick($banner_id);
            url::redirect($b['banner_url']);
        }

    }
}

?>
