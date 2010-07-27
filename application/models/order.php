<?php
 class Order_Model extends Table_Model {
     public $table  = 'orders';
     public $id = 'order_id';
     public $validation = array();
     
    public function __construct() {
        parent::__construct();
    }

    public function save($billing_address_id, $shipping_address_id, $shipping_id, $note, $items ){
        $order = array(
            'shipping_id'=>$shipping_id,
            'shipping_address_id'=>$shipping_address_id,
            'billing_address_id'=>$billing_address_id,
            'note' => $note,
        );

        $order_id = $this->add($order);
        $order_item = new Table_Model('order_items', 'order_item_id');
        foreach($items as $item){
            $item_data = array('order_id'=>$order_id,'product_price_id'=>$item['product_price_id']);
            $order_item->add($item_data);
        }
    }
 }
?>
