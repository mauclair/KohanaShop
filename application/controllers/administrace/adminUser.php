<?php
class AdminUser_Controller extends Administrace_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User_Model;
    }

    public function index(){
        $this->userList();
    }

    public function edit($user_id){
        $um = new User_Model();
        $u = $um->get($user_id);
        if(!$u) url::redirect('administrace/adminUser/userList');
        $this->template->content = View::factory('admin/user/edit')->set($u)->render();
    }

     public function update(){
        $u = new User_Model();
        if($u->update($this->input->post())) {
            error::add(Kohana::lang('main.success'),'message');
        } else {
            error::add(Kohana::lang('main.failed'));
        }
        url::redirect($this->session->get('last-page','/'));
    }

     public function add(){
        $u = new User_Model();
        $_POST['password'] = md5($_POST['password']);
        $_POST['password_again'] = md5($_POST['password_again']);
        $this->model->add($_POST);
        url::redirect('admin/userList');
    }

    public function newUser(){
        $this->template->content = View::factory('admin/user/new');
    }

    public function userList(){
        $view = View::factory('admin/generic/table');
        $view->set('data',$this->model->fetch());
        $view->langfile = 'user';
        $view->sortable= array('name','lang');
        $view->fields = array('name','email','shopper_group_name');
        $this->template->content = $view->render();
    }



   
    
}
?>
