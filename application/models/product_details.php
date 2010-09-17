<?php
 class Product_details_Model extends Table_Model {
     public $table = 'product_details';
     public $id = 'id';
     public $validation = array('product_id'=>  array('required'));

     
     
 }

?>
