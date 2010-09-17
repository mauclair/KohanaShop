<?php
/**
 * @property Product_Model $model
 */
class AdminProducts_Controller extends Administrace_Controller {

    public function __construct() {
        parent::__construct();
        $this->model = new Product_Model();
        $this->redirect_to = $this->session->get('current-page');
        
    }

    public function index(){
        url::redirect('administrace/adminProducts/seznam');
    }

    public function seznam() {
        $default_filter = array('product_publish'=>false,'vendor_id'=>false,'category_id'=>false,'indikace_id'=>false,'product_special'=>false);
        $filters = $this->session->get('administrace/adminProducts.filters',$default_filter);
        $this->model->apply_filters($filters);
        $sort = $this->session->get('administrace/adminProducts.sort',  array('field'=>'product_name','desc'=>'asc'));
        $this->model->orderBy($sort['field'], $sort['desc']);
        $count = $this->model->fetch()->count();
        $pagination = new Pagination(array('total_items'=>$count,'base_url'=>'administrace/adminProducts/seznam/','uri_segment'=>'strana'));
        $offset = $pagination->sql_offset;

        //$this->model->apply_search($string)
        $this->model->limit($offset,$pagination->items_per_page);
        

        $v = View::factory('admin/products/table');
        $v->sort = $sort;
        $v->set('pagination',$pagination->render('digg'));
        $v->filters=$filters;
        $v->vendors = Table_Model::factory('vendor', 'vendor_id')->getForSelect('vendor_id', 'vendor_name' ,true);
        $v->data =  $this->model->fetch();
        $this->template->content = $v->render();
    }

    public function edit($product_url){
        $product = $this->model->get($product_url,'product_url');
        if(!$product) url::redirect('administrace/adminProducts');
        $view = View::factory('admin/products/edit');
        $view->set($product);
        $mVendor  = new Vendor_Model();
        $view->vendors = $mVendor->getForSelect('vendor_id', 'vendor_name',true);
        
        $view->details = $this->product_details($product['product_id'],false);       
        $view->tags = $this->indikace($product['product_id'],false);
        $view->categories = $this->categories($product['product_id'],false);
            
        $this->template->content = $view->render();
    }

    public function indikace($product_id,$set_content = true){
        $indikace  = new Tag_Model();
        $res = View::factory('admin/products/tags')->set('tags',$indikace->getTags((int)$product_id))->render();
        if($set_content)$this->template->content = $res;  else return $res;
    }

    public function categories($product_id,$set_content = true){
        $categories = new Category_Model();
        $res = View::factory('admin/products/categories')->set('categories',$categories->forProduct((int)$product_id))->render();
        if($set_content)$this->template->content = $res; else return $res;
    }
    
    public function product_details($product_id,$set_content = true){
        $details = new Product_details_Model();
        $details->where('product_id',$product_id);
        $res = View::factory('admin/products/details')->set('details',$details->fetch())->render();
        if($set_content)$this->template->content = $res; else return $res;
    }



    public function togglePublish($product_id){
        $product = $this->model->get((int)$product_id);
        

    }

}

?>
