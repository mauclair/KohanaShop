<?php
class Pay_Model extends Table_Model {
    public $table = 'payment_method';
    public $validation = array();
    public function __construct() {
        parent::__construct();

    }
}
?>
