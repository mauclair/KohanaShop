<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product
 *
 * @author snoblucha
 */
class Product_Model extends Table_Model {
    public $table = 'product';
    public $id = 'product_id';

    public function __construct() {
        parent::__construct();
        $this->joins[] = array('table'=>'vendor', 'field'=>'vendor_id');
        $this->joins[] = array('table'=>'product_category_xref', 'field'=>'product_id');
        $this->joins[] = array('table'=>'category', 'field'=>'category_id');
        $this->joins[] = array('table'=>'indikace_xref','field'=>'product_id');
        $this->joins[] = array('table'=>'indikace','field'=>'indikace_id');
        $this->joins[] = array('table'=>'product_price', 'field'=>'product_id');
        $this->addFilter('shopper_group_id', is::group());
        $base = url::base();
        $f =  "GROUP_CONCAT(DISTINCT CONCAT('<a href=\"{$base}indikace/',indikace_id,'\">',indikace{$_SESSION['lang']},'</a>' ) SEPARATOR ', ' ) as indikace";
        $this->fields = array('*',$f);
        $this->groupBy = 'product_id';
    }
}
?>
