<?php
class Vendor_Model extends Table_Model {
    public $table = 'vendor';
    public $id = 'vendor_id';
    public $autoUrl = array('vendor_name'=>'vendor_url');

    public function __construct() {
        parent::__construct();

    }
    
}
?>
