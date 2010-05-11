<?php
 class User_info_Model extends Table_Model {
     public $table = 'user_info';
     public $id = 'user_info_id';
     public $validation = array(            
            'name'  => array('required','length[1,128]'),
            'address_1' =>array('required','length[1,255]'),
            'city' => array('required','length[1,128]'),
            'zip' => array('required','length[5,8]'),
         );
     public function __construct() {
         parent::__construct();

     }
 }

?>
