<?php
class Administrace_Controller extends Admin_Controller{
    public function index(){
            $this->template->content = 'test';;
            $this->template->leftMenu = 'UUU';
    }
}

?>
