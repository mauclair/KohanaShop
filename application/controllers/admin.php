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
class Admin_Controller extends My_Controller {    
    public $template = 'admin/template';
    public function __construct() {
        parent::__construct();
        $logged = User_Model::isLogged();                
    }

    

    public function index(){
        $this->userList();
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
        $ltm = new LocalizableTable_Model('cs',array('name','short_text','long_text'),'girls');
        $ltm->_createTable('cs');
    }
    
}
?>
