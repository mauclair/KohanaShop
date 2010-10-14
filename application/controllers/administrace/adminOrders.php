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
        $filters  = $this->session->get('administrace/adminOrders.filters',  array());
        $this->model->apply_filters($filters);
        $view = new View('admin/generic/table');
        $view->modelname = 'order';
        $view->prepend = View::factory('admin/generic/filters')
                            ->set('names',  array('order_status'=>  Kohana::lang('order.order_status')))
                            ->set('filters',  array('order_status'=> array('')+Kohana::lang('order.status_str')))
                            ->set('values',$filters)
                ;
        $view->fields = array('order_number','cdate','name','order_status','order_subtotal');
        $view->sortable = $view->fields;//array('name','order_subtotal');
        $view->sort = $sort;
        $view->viewRow = new View('admin/orders/row');
        $view->data = $this->model->orderBy($sort)->fetch();
        $this->template->content = $view->render();
    }

    public function detail($order_number){
        $order = $this->model->getOrder($order_number);
        if(!$order) url::redirect('administrace/adminOrders/seznam');
        $order['billing_address'] = View::factory('user_info/read_only_html')->set($order['billing_address'])->render();
        if($order['shipping_address']) $order['shipping_address'] = View::factory('user_info/read_only_html')->set($order['shipping_address'])->render();
        $view = View::factory('admin/orders/detail')->set($order);
        $view->order = View::factory('admin/orders/order')->set($order);
        $view->controls = 'CONTROLS';
        $this->template->content =$view->render();
    }
}
?>