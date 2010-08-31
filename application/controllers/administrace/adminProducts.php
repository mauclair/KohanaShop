<?php
/**
 * @property Product_Model $model
 */
class AdminProducts_Controller extends Administrace_Controller {

    public function __construct() {
        parent::__construct();
        $this->model = new Product_Model();
    }

    public function index(){
        url::redirect('administrace/adminProducts/seznam');
    }

    public function seznam() {
        $filters = $this->session->get('administrace/adminProducts.filters',array('product_publish'=>false,'vendor_id'=>false,'category_id'=>false,'indikace_id'=>false));        
        $count = $this->model->fetch()->count();
        $pagination = new Pagination(array('total_items'=>$count,'base_url'=>'administrace/adminProducts/seznam/','uri_segment'=>'strana'));
        $offset = $pagination->sql_offset;        
        $this->model->limit($offset,$pagination->items_per_page);        
        $v = View::factory('admin/products/table');        
        $v->set('pagination',$pagination->render());
        $v->filters=$filters;
        $v->vendors = Table_Model::factory('vendor', 'vendor_id')->getForSelect('vendor_id', 'vendor_name' ,true);
        $v->data =  $this->model->fetch();
        $this->template->content = $v->render();
    }

    public function edit($product_id){
        $product = $this->model->get($product_id);
        if(!$product) url::redirect('adminProducts');
        $view = View::factory('admin/products/edit');
        $view->set($product);
        $this->template->content = $view->render();
    }

}

?>
