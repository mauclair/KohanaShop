<?php
class AdminUser_Controller extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User_Model;
    }

    public function edit($user_id){
        $um = new User_Model();
        $u = $um->get($user_id);
        if(!$u) url::redirect('admin/userList');    
        $this->iTemplate->content = View::factory('admin/user/edit')->set($u)->render();
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
        $this->iTemplate->content = View::factory('admin/user/new');
    }

   
    
}
?>
