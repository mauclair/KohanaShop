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
class User_Controller extends My_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User_Model();

    }

    public function index(){
        
    }

    public function login(){
        if($this->model->try_login('snb',md5('snb'))){            
            $this->template->content = Kohana::debug($_SESSION['user']);
        } else {
            error::add(Kohana::lang('user.lofing-failed'));            
        }
        url::redirect($this->session->get('last_page'));
    }

    public function logout(){
        $this->model->logout();
        url::redirect(url::base());
    }
}
?>
