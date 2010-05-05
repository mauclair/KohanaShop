<?php
class Report_Model extends Table_Model {
   public $table = 'report';
   public $id = 'report_id';
   public $validation = array('user_id'=>array('required'), 'vymol_id'=>'required');

   public function __construct() {
       parent::__construct();
       // add join ?       
   }

   public function add(&$d){
        $d['reported_date'] = date('Y-m-d H:i:s');
        $exists = $this->get(array(
                    'user_id'=>$d['user_id'],
                    'vymol_id'=>$d['vymol_id'],
                    'DATEDIFF(NOW(),reported_date) < '. Kohana::config('main.report-same-type-after')=>array('operator'=>'','value'=>false,'no-escape'=>true),
                    'report_type'=>$d['report_type'],
                  ));
        if($exists) {            
            return -1;
        }

        parent::add($d);
    }
}
?>