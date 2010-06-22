<?php
/**
 * @property Clanky_Model $model
 */
class Clanky_Controller extends Shop_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Clanky_Model();
        include Kohana::find_file('vendor','Texy');
    }
    public function index(){
        $this->model->andnot('top_menu','Y');
        $data = $this->model->fetch();        
        $this->template->content = View::factory('clanky/list')->set('clanky',$data)->render();

    }

    public function  __call($name,  $arguments) {
        $c = $this->model->get($name,'clanky_url');
        if($c) {
            $this->_show($c);
        } else throw  new Kohana_404_Exception();
    }

    public function _show($clanek){
        $p = new Product_Model();
        $p->where->in('product_id',"SELECT product_id FROM product_clanky_xref WHERE cid = '{$clanek['cid']}'");
        $products = View::factory('product/items')->set('products',$p->fetch())->render();
        $this->template->content = View::factory('clanky/detail')->set($clanek)->set('products',$products);
    }



    public function updateUrls(){
        $this->model->updateUrls();
    }  

    public function convertToHtml(){
        $c = $this->model->convertAllToHtml();
    }
}
?>
