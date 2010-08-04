<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 class Order_items_Model extends Table_Model {
     public $table = 'order_item';
     public $id = 'order_item_id';

     public function __construct() {
         parent::__construct();
         $this->join('product', 'product_id');
         $this->join('product_price', 'product_price_id');
    }

 }
?>
