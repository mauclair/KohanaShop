<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud
 *
 * @author snoblucha
 * @property Session $session
 * @property object $model
 */
class Crud_Controller extends Template_Controller {
    public $model;
    public $redirect_to;
    public $session;
    public function  __construct() {
        $this->session = Session::instance();
        if(!$this->redirect_to) $this->redirect_to = $this->session->get('last_page');
        parent::__construct();
    }

    public function add(){
        $id = $this->model->add($this->input->post());
        url::redirect($this->redirect_to);
    }

    public function delete($id){
        if(!$id) url::redirect($this->redirect_to);
        $this->model->delete($id);
        url::redirect($this->redirect_to);
    }

    public function update(){
        $this->model->update($this->input->post());
        url::redirect($this->redirect_to);
    }

}
?>
