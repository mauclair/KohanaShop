<?php
 class Order_Model extends Table_Model {
     public $table  = 'orders';
     public $id = 'order_id';
     public $validation = array();
     
    public function __construct() {
        parent::__construct();

    }
 }
?>
