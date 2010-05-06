<?php

class User_Controller extends My_Controller{
    public $user;
    public $logged;
    public function __construct() {
        parent::__construct();
        $this->user = $this->session->get('user');
        $this->logged =  ($this->user) ? true : false;
        
        /*$m = $this->uri->segment(2);
        $alowed_unlogged =  array('login','loginAction');
        if(!$this->logged  &&  !in_array($m, $alowed_unlogged) )url::redirect('user/login');*/

        
    }

    public function index(){
        if($this->logged) $this->listUsers(); else $this->login();
    }

    public function login(){
        $this->template->content = View::factory('user/login')->render();
        $this->template->title = Kohana::lang('user.login');
    }
    /**
     * List all  users
     */
    public function listUsers(){
        $u  =new User_Model();
        $this->template->content = View::factory('user/list')->set('users',$u->fetch())->render();
    }

    public function loginAction(){
        $u = new User_Model();
        if($u->login($this->input->post('email'),md5($this->input->post('password')))) {
            url::redirect();
        } else url::redirect($this->session->get('go-after-login',$this->session->get('last-page','/')));

    }

    public function update(){
        $u = new User_Model();      
        $u->update($this->input->post());
        url::redirect('user/listUsers');
    }

    public function add(){
        $u = new User_Model();
        $_POST['password'] = md5($_POST['password']);
        $_POST['password_again'] = md5($_POST['password_again']);
        $u->add($_POST);
        url::redirect('user/listUsers');
    }

    public function delete($user_id){
        $u = new User_Model();
        $u->delete($user_id);
        url::redirect('user/listUsers');
    }

    public function edit($user_id){
        $um = new User_Model();
        $u = $um->get($user_id);
        if(!$u) url::redirect('user/listUsers');
        $this->template->content = View::factory('user/edit')->set($u)->render();
    }

    public function newUser(){
        $this->template->content =   View::factory('user/new')->render();
    }

    public function logout(){
        $this->session->delete('user');
        url::redirect($this->session->get('current-page','user/index'));
    }

    public function no_perms(){
        $this->template->content = 'NO PERMS FOR YOU MAN';
    }

   
}

?>
