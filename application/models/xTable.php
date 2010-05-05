<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xTable
 *
 * @author snoblucha
 */
class XTable_Model extends Table_Model {
    //put your code here
    public $xTables = array();
    public function __construct($table = false, $xTables = array()){
        if($xTables) $this->xTables = $xTables;
        foreach($this->xTables as $tab){
            $this->joins[] = array('table'=>$tab, 'field'=>$tab.'_id');
            $this->validation[$tab.'_id'] = array('required');
            $this->schema[$tab.'_id'] = 'INT NOT NULL';
            
        }        
        parent::__construct($table);
        $this->checkTable();
    }

    public static function factory($table,$xTables){
        $m =  new XTable_Model($table,$xTables);
        $m->table = $table;
        return $m;
    }

    public function add(&$d){
        $w = '';
        foreach($this->xTables as $tab){
            $id = $tab.'_id';
            $w .= ($w) ? ' AND ' : '';
            $w .= "$id = '{$d[$id]}'";
        }
        $w = ($w) ? 'WHERE '.$w : '';
        $q = "SELECT {$this->id} FROM {$this->table} $w";
        $res = $this->db->query($q);
        if($res->count()==0) return parent::add($d);
    }
}
?>
