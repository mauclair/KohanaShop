<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author snoblucha
 */
class Administrace_Controller extends My_Controller {
    public $template = 'admin/template';
    
    public function __construct() {
        parent::__construct();
        if(!Perms_Core::allowed()) url::redirect('uzivatel/prihlasit');
        $logged = User_Model::isLogged();
        $this->template->menu = View::factory('admin/menu');
    }
   

    public function index(){
        $this->template->content = 'administration';
    }

    public function userList(){
        $u = new User_Model();        
        $level = $this->session->get('admin/userList.filters.level');
        if($level!='') {
            $u->where->where('level', $level);
        }
        $sort=$this->session->get(url::current().'.sort',array('name'));          
        $u->orderBy(implode(' ',$sort));
        $data = $u->fetch();
        $v = View::factory('admin/user/list')->set('level',$level);
        $v->users = $data;
        $this->iTemplate->content =  $v->render();
    }    

    public function test(){
      
    }

    public function toggle($id,$field,$value=false){
        $item = $this->model->get((int)$id);
        if($item && isset($item[$field])){
            if($value) $item[$field] = $value; else $item[$field]= $item[$field] ? false : true;
            $this->model->update($item);
            $this->template->content = json_encode($item);
        } else $this->template->content = 'ERROR';
        if(!request::is_ajax()) url::redirect(Session::instance ()->get('current-page'));
    }
    
}
?>
