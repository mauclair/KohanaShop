<?php
 class Order_Model extends Table_Model {
     public $table  = 'orders';
     public $id = 'order_id';
     public $validation = array(
                'billing_address_id'=>  array('required','valid::numeric'),
                'shipping_address_id'=>  array('required','valid::numeric'),
                'shipping_id'=>  array('required','valid::numeric'),

         );
     
    public function __construct() {
        parent::__construct();
        $this->join('user_info', null, 'JOIN', 'user_info.user_info_id=orders.billing_address_id');
    }

    public function save($billing_address_id, $shipping_address_id, $shipping_id, $note, $items ){
        $this->query("START TRANSACTION");
        $order = array(
            'shipping_id'=>$shipping_id,
            'shipping_address_id'=>$shipping_address_id,
            'billing_address_id'=>$billing_address_id,            
            'note' => $note,
        );
        $shipping_model = new Shipping_Model();
        $shipping_detail = $shipping_model->get($shipping_id);
        $order['order_id'] = $this->add($order);
        $order['order_number'] = date('Ym').$order['order_id'];

        if(!$this->update($order)) {
            $this->query("ROLLBACK");
            error::add(Kohana::lang('orders.errors.updating-order'));
            return false;
        }
        $order_item = new Table_Model('order_item', 'order_item_id');
        foreach($items as $item){
            $item_data = array(
                'order_id'=>$order['order_id'],
                'product_id'=>$item['data']['product_id'],
                'product_price_id'=>$item['data']['product_price_id'],
                'product_item_price'=>$item['data']['product_price'],
                'product_quantity'=>$item['count'],

             );
            if(!$order_item->add($item_data)) {
                $this->query("ROLLBACK");
                error::add(Kohana::lang('orders.errors.adding-item'));
                return false;
            }
        }
        $this->query("COMMIT");
        return $order['order_number'];
    }

    public function getOrder($order_number){
        $result = array();
        $result = $this->get($order_number, 'order_number');
        if(!$result) return false;
        $user_info_model = new User_info_Model();


        $result['billing_address'] = $user_info_model->get($result['billing_address_id']);
        if($result['billing_address_id']==$result['shipping_address_id']) {
            $result['shipping_address'] = $result['billing_address'];
            $result['same_address'] = true;
        } else {
            $result['shipping_address'] = $user_info_model->get($result['shipping_address_id']);
            $result['same_address'] = false;
        }
        $shipping_model = new Shipping_Model();
        $result['shipping'] = $shipping_model->get($result['shipping_id']);
        $order_items = new Order_items_Model();
        $order_items->where('order_id',$result['order_id']);
        $result['items'] = $order_items->fetch();
        return $result;
    }

    
 }
?>
