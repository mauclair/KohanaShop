<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kategorie
 *
 * @author snoblucha
 */
class Kategorie_Controller extends Shop_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Category_Model();
    }
    
    public function index(){

    }
    /**
     * Vypise objekty z kategorie 
     * @param array $cat  - category line array
     */
    private function _kategorie($cat){
        $prod = new Product_Model();
        $order = $this->session->get('ketegorie.sort');
        $group = $this->session->get('user.shopper_group_id',Kohana::config('main.default-shopper-group'));
        $this->template->content = View::factory('product/items')
                ->set('products',cacheControl::products_in_category($cat['category_id'],$order,$group))->render();
    }

    public function __call($method, $arguments){
        $cat = $this->model->getPlain($method,'category_url');
        if($cat) {
            $this->_kategorie($cat);
            return;
        } else throw (new Kohana_404_Exception());
    }

    public function updateUrls(){
        $this->model->updateUrls();
        Cache::instance()->delete_tag('categories');
    }
}
?>
