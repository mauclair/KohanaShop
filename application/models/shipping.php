<?php
class Shipping_Model extends Table_Model{
    public $table = 'shipping';
    public $id = 'shipping_id';
    public $validation = array('shipping_cost'=>array('required','valid::numeric'), 'shipping_name'=>'required');
    public function __construct() {
        parent::__construct();

    }
/**
 * Return Shipping cost for order with given subtotal
 * @param int $shipping_id
 * @param decimal $order_subtotal
 * @return decimal
 */
    public static function getShippingCost($shipping_id, $order_subtotal){
        $shm = new Shipping_Model();
        $shipping = $shm->get($shipping_id);
        if($shipping['shipping_limit']>$order_subtotal) return $shipping['shipping_cost']; else return 0;
    }

}

?>
