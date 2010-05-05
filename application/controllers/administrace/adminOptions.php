<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminOptions
 *
 * @author snoblucha
 */
class AdminOptions_Controller extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Options_Model();
        $this->redirect_to = 'adminOptions';
    }
    public function index(){
        $this->template->content = View::factory('admin/options/list')->set('options',$this->model->fetch());
    }

    public function insert(){
        $p = $this->input->post();
        Options_Model::set($p['key'], $p['value']);
        url::redirect($this->redirect_to);
    }
}
?>
