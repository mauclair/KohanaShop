<?php
class Rating_Controller extends My_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Rating_Model();
    }

    public function add(){
        $d = $this->input->post();
        $u = $this->session->get('user');
        if($u){//got user
            $d['user_id'] = $u['user_id'];
            $this->model->add($d);
        }
    }
}
?>