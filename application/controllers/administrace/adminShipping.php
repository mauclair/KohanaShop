<?php
/**
 * @property Shipping_Model $model
 */
class AdminShipping_Controller extends Administrace_Controller{
    public function __construct() {
        parent::__construct();
        $this->model = new Shipping_Model();
        
    }
    
    public function index(){
        $view = View::factory('admin/generic/table');
        $view->sortable  = array('shipping_name');
        $view->data = $this->model->fetch();
        $view->fields = array('shipping_name','shipping_cost','shipping_limit');
        $view->modelname = 'shipping';
        $this->template->content = $view->render();
    }

    public function edit($shipping_id){
        $data = $this->model->get($shipping_id);
        if(!$data) url::redirect('administrace/adminShipping');
        $view = View::factory('admin/shipping/edit');
        $this->template->content = $view->render();
    }

}
?>
