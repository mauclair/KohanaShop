<?php
class Upgade_Controller extends Shop_Controller{
    public function index(){
        $model = new Clanky_Model();
        $c->updateUrls();
        $c->convertAllToHtml();

        $model = new Product_Model();
        $model->updateUrls();

        $model = new Category_Model();
        $model->updateUrls();
    }
}

?>
