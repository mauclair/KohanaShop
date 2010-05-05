<?php
class CacheControl_Core {
    public function __construct() {

    }
/**
 *  Gets cached catagory list for specified customer group
 * @param int $group_id
 * @return array
 */
    public static function categories($group_id=false) {
        $cache = cache::instance();

        $cache_id = 'categories-'.$group_id;
        $categories = $cache->get($cache_id);
        if(!$categories) {
            if(!$group_id) $group_id = Kohana::config('main.default-shopper-group');
            $q = "CREATE TEMPORARY TABLE products_info
                   SELECT category_id, count(*) as product_count FROM product
                   JOIN product_price USING (product_id)
                   JOIN product_category_xref USING (product_id)
                   WHERE shopper_group_id = '$group_id'
                    AND  product_publish = 'Y'
                   GROUP BY category_id
                ";
            $cat = new Table_Model('category','category_id');
            $cat->query($q);
            $cat->join('products_info','category_id');
            $cat->orderBy(array('vaha desc','category_name'));
            
            //$cat->where->in('product_id',"SELECT product_id FROM product_price WHERE shopper_group_id ='$group_id'");
            //$cat->join('product_price', 'product_id');
            //$cat->where('product_publish','Y');
            $categories =  $cat->fetch()->result_array(false);
            $cache->set($cache_id, $categories,array('categories'));
        }
        return $categories;
    }
/**
 *  Gets cached products for specified category and customer gorup
 * @param int $category_id
 * @param string order_by
 * @param int $group_id
 */
    public static function products_in_category($category_id,$order_by='product_name',$group_id=false){
         $cache = cache::instance();
         $cache_id = 'products-'.$category_id.'-'.$order_by.'-'.$group_id;
         $products = $cache->get($cache_id);
         if(!$products){
             $prod = new Product_Model();
             $prod->where->where('category_id', $category_id)->where('product_publish','Y');
             $prod->where('shopper_group_id',$group_id);
             if($order_by)$prod->orderBy($order_by);
             $products =  $prod->fetch()->result_array(false);
             $cache->set($cache_id,$products,array('products'));
         }
         return $products;
    }
}

?>
