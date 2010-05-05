<?php
 class Rating_Model extends Table_Model {
     public $table = 'rating';
     public $id = 'rating_id';

      public function add(&$d){
        $d['rating_date'] = date('Y-m-d H:i:s');
        $exists = $this->get(array(
                    'user_id'=>$d['user_id'],
                    'vymol_id'=>$d['vymol_id'],
                    'DATEDIFF(NOW(),rating_date) < '. Kohana::config('main.report-same-type-after')=>array('operator'=>'','value'=>false,'no-escape'=>true),
                  ));
        if($exists) {
            return -1;
        }
        parent::add($d);
    }
 }

?>
