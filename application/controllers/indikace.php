<?php
class Indikace_Controller extends Shop_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Indikace_Model();
    }

    public function  __call($name,  $arguments) {
        $p = $this->model->get($name,'indikace_url');
        if($p) {
            $this->_show($p);
        } else throw new Kohana_404_Exception();
    }

    public function _show($indikace){
        $data = $this->model->getProducts($indikace['indikace_id']);
        $prods = View::factory('product/items')->set('products',$data)->render();
        $this->template->content = View::factory('indikace/produkty')->set($indikace)->set('products',$prods)->render();
    }

    public function updateJTable(){
        $this->model->updateIrefsTable();
    }
}
?>
