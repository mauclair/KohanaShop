<?php
/**
 * @property Order_status_Model $model
 */
class AdminOrderStatus_Controller extends Administrace_Controller {

    public function __construct() {
        parent::__construct();
        $this->model = new Order_status_Model();
    }

    public function index(){
        $data = $this->model->fetch();
        $view = View::factory('admin/generic/table');
        $view->fields =  array('order_status_code','order_status_name');
        //$view->viewRow = new View('admin/orders/status_row');
        $view->modelname = 'order_status';
        $view->id = $this->model->id;
        $view->data = $this->model->fetch();
        $this->template->content = $view->render();
    }

    public function edit($id){
        $data = $this->model->get($id);
        if(!$data) url::redirect('administrace/adminOrderStatus');
        
    }
}

?>
