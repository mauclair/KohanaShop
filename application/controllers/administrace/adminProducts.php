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
        $this->seznam();
    }

    public function seznam() {
        
        $count = $this->model->fetch()->count();
        $pagination = new Pagination(array('total_items'=>$count,'base_url'=>'administrace/adminProducts/seznam/','uri_segment'=>'strana'));
        $offset = $pagination->sql_offset;
        echo Kohana::debug($pagination);
        $this->model->limit($offset,$pagination->items_per_page);
        $products = $this->model->fetch();
        
        $this->template->content = $pagination->render();
    }

}

?>
