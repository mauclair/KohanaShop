<?php
class Shipping_Model extends Table_Model{
    public $table = 'shipping';
    public $id = 'shipping_id';
    public $validation = array('shipping_cost'=>array('required','valid::numeric'), 'shipping_name'=>'required');
    public function __construct() {
        parent::__construct();

    }

}

?>
