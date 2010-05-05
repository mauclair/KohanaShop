<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of basket
 *
 * @author snoblucha
 */
class Basket_Controller extends My_Controller {
    public $basket;
    public function  __construct() {
        parent::__construct();        
        $this->model = new Basket_Model();
    }

    public function add(){
        $this->model->add($this->input->post());
        $this->template->content = Kohana::debug($this->model->get());
    }
}
?>
