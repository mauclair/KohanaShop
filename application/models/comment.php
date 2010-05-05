<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comment
 *
 * @author snoblucha
 */
class Comment_Model extends Table_Model {
    public $table = 'comments';
    public $id = 'comment_id';
    public $validation = array('user_id'=>array('valid::numeric'),'comment'=>array('required'));
    public $fields = array('*', "DATE_FORMAT(created, '%H:%i %e.%c.%Y') as nice_date");
    public $sortBy = 'created';

    public function __construct() {
        parent::__construct();
        $this->joins[] = array('table'=>'user','field'=>'user_id', 'type'=>'left join');
    }

    public function add(&$d){
        $d['created'] = date('Y-m-d H:i:s');
        echo Kohana::debug($d);
        parent::add($d);
        
    }
}
?>
