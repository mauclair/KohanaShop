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
        $this->join('vendor','vendor_id');
        $this->join('product_details', 'product_id','LEFT JOIN');
        $this->join('product_category_xref', 'product_id');
        $this->join('category', 'category_id');        
        $this->join('indikace_joined','product_id','LEFT JOIN');        
        $this->join('product_price','product_id');
        $this->join('product_taxes','product_taxes_id');
        $this->where('shopper_group_id',Session::instance()->get('user.shopper_group_id',Kohana::config('main.default-shopper-group')));
        $base = url::base();
        //$f =  "GROUP_CONCAT(DISTINCT CONCAT('<a href=\"{$base}indikace/',indikace_id,'\">',indikace_{$_SESSION['lang']},'</a>' ) SEPARATOR ', ' ) as indikace";
        
        $this->fields = array('*',"i_refs_". Session::instance()->get('lang','cz')." as indikace");
        $this->groupBy = 'product_id';
    }

    public function updateUrls(){
        $m = Table_Model::factory('product','product_id');
        $data = $m->fetch();
        set_time_limit(0);
        foreach($data as $p){            
            $t = (array)$p;
            $t['product_url'] = url::title($t['product_name']);
            $m->update($t);
            unset($t);
        }
    }

    public static function getPrize($data){
        $taxmul = 1.0 + $data['product_taxes_value'] * 0.01;
        $oprize = $data['product_price'] * $taxmul;
        $nprize = $oprize * (1.0 - $data['product_discount_id'] * 0.01 );
        return array('prize'=>$nprize,'old-prize'=>$oprize,'delta'=>$oprize  - $nprize, 'discounted'=>$data['product_discount_id'] > 0);
    }
}
?>
