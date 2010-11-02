<?php
/**
 * @property Overview_Model $model 
 */
class AdminOverview_Controller extends Administrace_Controller {

    function __construct() {
        parent::__construct();
        $this->model = new Overview_Model();
     }
     
     public function index(){
         $view = View::factory('admin/overview/byMonths');
         $view->data = $this->model->byMonths();
         $view->chart = View::factory('admin/overview/chart')->set('chart_id','byMonth')
                        ->set('chart_data_url',url::site('administrace/adminOverview/chartByMonths'))->render();
         
         $this->template->content =$view->render();
     }

     public function chartByMonths($from=null,$to=null){
         $data = $this->model->byMonths($from, $to,'cdate');
         if($this->profiler)$this->profiler->disable();
         $this->auto_render = false;
         echo $this->model->chart($data, 'month',
                 array(
                     'revenue'=>array('color'=>'#aaa','key'=>Kohana::lang('orders.ordered')),
                     'revenue_S'=>  array('color'=>'#f06060','key'=>  Kohana::lang('orders.shipped')),
                     'shipped_shipping'=>  array('color'=>'#60f060','key'=>  Kohana::lang('orders.shipped_shipping'))
                     ),
                     array('month'=>  array($this->model,'formatMonth'))
                 );
     }



}
?>
