<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comments
 *
 * @author snoblucha
 */
class Comments_Controller extends My_Controller {
    public $model;
    public function __construct() {
        parent::__construct();
        $this->model = new Comment_Model();
    }

    public function vymol($vymol_id){
        $this->model->where->where('vymol_id', $vymol_id);
        $comments = View::factory('comments/list')->set('comments',$this->model->fetch())->render();
        $this->template->content = View::factory('comments/listWform')->set('comments',$comments)->set('vymol_id',$vymol_id)->render();
    }

    public function user($user_id){
        $this->model->where->where('user_id', $user_id);
        $this->template->content = View::factory('comments/list')->set('comments',$this->model->fetch())->render();
    }
}
?>
