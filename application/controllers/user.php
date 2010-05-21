<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author snoblucha
 */
class User_Controller extends Shop_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User_Model();

    }

    public function index(){

    }

    public function login(){
        $this->template->content = View::factory('user/login');
    }

    public function logout(){
        $this->model->logout();
        url::redirect(url::base());
    }
}
?>
