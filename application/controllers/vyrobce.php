<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Vendor_Model $model
 */

  class Vyrobce_Controller extends Shop_Controller {

      public function __construct() {
          parent::__construct();
          $this->model = new Vendor_Model();
     }

     public function __call($name, $arguments) {
         $vendor = $this->model->get($name,'vendor_url');
         if($vendor) {
            $this->_show($vendor);
         } else {
             throw new Kohana_404_Exception();
         }
     }

     private function _show($vendor){
         $products = new Product_Model();
         $products->where('vendor_id',$vendor['vendor_id']);
         $prods = View::factory('product/items')->set('products',$products->fetch())->render();
         $this->template->content = View::factory('vyrobce/produkty')->set($vendor)->set('products',$prods)->render();
     }

  }
?>
