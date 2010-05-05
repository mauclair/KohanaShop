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
            $cat = new Category_Model();
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
             $prod->addFilter('category_id', $category_id);
             $prod->sortBy = $order_by;
             $products =  $prod->fetch()->result_array(false);
         }
         return $products;
    }
}

?>
