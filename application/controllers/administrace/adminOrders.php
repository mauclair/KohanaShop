<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminOrders
 *
 * @author snb
 * @property Order_Model $model
 */
class adminOrders_Controller extends Administrace_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new Order_Model;
    }

    public function index(){
        url::redirect('administrace/adminOrders/seznam');
    }

    public function seznam(){
        $view = new View('admin/generic/table');
        $view->modelname = 'orders';
        $view->fields = array('name','order_subtotal','order_status');
        $view->sortable = array('name','order_subtotal');
        $view->data = $this->model->fetch();
        $this->template->content = $view->render();
    }
}
?>