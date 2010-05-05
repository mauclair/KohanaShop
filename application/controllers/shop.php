<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shop
 *
 * @author snoblucha
 */

class Shop_Controller extends My_Controller {    
    
    public function __construct() {
        parent::__construct();
        $this->template->categories = View::factory('layout/category_list')->set('categories',cacheControl::categories())->render();
    }
    public function index(){

    }

    public function produkty(){
        $prod = new Product_Model();
        $this->template->content = View::factory('product/items')->set('products',$prod->fetch())->render();
    }
}
?>
