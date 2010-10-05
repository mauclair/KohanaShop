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
        $sort = $this->session->get('administrace/adminOrders.sort',  array('field'=>'cdate','desc'=>'desc'));
        $view = new View('admin/generic/table');
        $view->modelname = 'orders';
        $view->fields = array('order_number','cdate','name','order_status','order_subtotal');
        $view->sortable = $view->fields;//array('name','order_subtotal');
        $view->sort = $sort;
        $view->viewRow = new View('admin/orders/row');
        $view->data = $this->model->orderBy($sort)->fetch();
        $this->template->content = $view->render();
    }
}
?>