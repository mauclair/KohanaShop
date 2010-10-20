<?php
 class Order_status_Model extends LocalizableTable_Model{
     public $table = 'order_status';
     public $id = 'order_status_id';
     protected $localized_fields = array('order_status_name','order_status_mail');
     protected $parent_language = 'cz';
     public function __construct() {
         parent::__construct();


    }
 }
?>
