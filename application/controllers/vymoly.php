<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vymoly
 *
 * @author snoblucha
 */
class Vymoly_Controller extends My_Controller{
    public $template = 'main_template';
    public $model;

    public function __construct() {
        parent::__construct();
        $this->model = new Vymol_Model();
    }
    
    public function index(){
        $user_tab = '';
        if(User_Model::isLogged()) $user_tab = View::factory('account/user_tab')->render();
        $this->template->content = View::factory('vymoly/choose')->set('user_tab',$user_tab)->render();
    }

   
    public function browse(){
        $this->template->content = View::factory('vymoly/browse')->set('search',$this->input->post('browse_address',Options_Model::ret('default_browse_address')))->render();
    }

    public function login(){
        
    }

    public function pridat(){
        $vars = $this->input->post();
        $vars['user_id'] = $this->session->get('user.user_id');
        $vars['vymol_id'] = $this->model->add($vars);        
        if($vars['saveimage']=='Y' && $vars['image_file']){//want to store image and have image                        
            Table_Model::factory('image')->add($vars);
            $this->cache->delete($this->session->id()); // delete cache storing image. wil lnot be deleted any more
        }

    }

    public function getHoles(){
        $this->template->content = View::factory('vymoly/json_holes')->set('holes',$this->model->getHoles($this->input->post()))->render();
    }

    public function uploadImages(){
        Kohana::log('error', Kohana::debug($this->input->post()));
        $gim = new Image_Model();
        $gim->add($this->input->post());
        echo 'true';

    }

    public function images(){
        $id = $this->input->post('vymol_id');
        $im = new Image_Model();
        $im->where->where('vymol_id', intval($id));
        $this->template->content = View::factory('vymoly/imageList')->set('images',$im->fetch())->render();
    }

    public function detail($vymol_id){
        $data = $this->model->get((int)$vymol_id);
        if(!$data) return;
        Logger_Model::viewVymol($vymol_id);
        $rating = View::factory('vymoly/rating')->set($data)->set('admin',User_Model::isAdmin())->render();
        $controls = View::factory('vymoly/controls')->set($data)->set('admin',User_Model::isAdmin())->set('rating',$rating)->render();
        
        $this->template->content = View::factory('vymoly/detail')->set($data)->set('controls',$controls)->render();
    }

    public function rating($vymol_id){
        $data = $this->model->get((int)$vymol_id);
        if($data) $this->template->content =  View::factory('vymoly/rating')->set($data)->render();

    }    

    public function uploadGPSImage(){
        
        $t = new Image_Model();
        $d = $this->input->post();
        $t->processFiles($d);
        $this->auto_render = false;
        $res = ImageGps_Model::getString($d['image_file']);
        $fname = $d['image_file'];
        $tfname = str_replace('upload/images', 'upload/thumbs', $fname);
        $tag = $fname;
        $ufiles  = $this->cache->get($d['sid']);
        if($ufiles) {
                @unlink($ufiles['filename']);
                @unlink($ufiles['thumbfilename']);
                $this->cache->delete($d['sid']);
        }
        
        if($res=='false') {
            // get rid of the dammed files
            @unlink($fname);
            @unlink($tfname);
        } else { // OK got exif
            $store = array('filename'=>$fname,'thumbfilename'=>$tfname,'location'=>$res);
            $this->cache->set($d['sid'],$store );
            $res = json_encode($store );
        }
        $this->template->content = $res;
        echo $this->template->content;
    }

     public function getIpLoc(){         
        $this->template->content = json_encode($this->session->get('ipLoc',$_SESSION));
    }
}
?>
