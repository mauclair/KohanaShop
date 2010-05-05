<?php
class Style_Controller extends Controller {
    public $cache;
    public $data;
    public function __construct() {
        parent::__construct();
        $this->cache = cache::instance();

    }

    public function index() {

    }

    public function screen() {
        $data = $this->cache->get()
    }

    public function _send($data){

    }


}
?>
