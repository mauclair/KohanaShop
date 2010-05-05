<?php
class Condition_Core {
    private $filters;
    private $db;

    public function __construct() {
        $this->filters = array();
        
        $this->db = new Database_Core();
    }

    public static function factory(){
        $class = get_class();
        return new Condition_Core();
    }

    public function  __toString() {
        return $this->get();
    }

    public function get(){
        $res = '';        
        foreach($this->filters as $v){
            if($res) $res.= ' '.$v['type'].' '; 
            else if(strpos($v['type'], 'NOT')!== false) $res .= ' NOT';
            if(isset($v['cond'])){
                $res .= $v['cond']->get();
            } else {
                $res .= $v['field'].' '.$v['operator'].' '.$v['value'];
            }
        }
        return ($res)  ?  '('.$res.')' : false;
    }


    public function __call($method,$args){        
        if($method=='and') {
            return call_user_func_array(array($this,'where'), $args);

        } else if ($method=='or'){
            return call_user_func_array(array($this,'orwhere'), $args);
        } else throw new Kohana_404_Exception();

    }

    /**
     * Set the AND part of where ...
     * @param string/array $field - can be pairs key=>$value, for comparision will be used operator
     * @param value/null $value
     * @param string $operator - =, < , > , ...
     * @param boolean $escape  Should we escape the key and val,  for security ... yes
     * @return $this - for chaining
     */
    public function where($field,$value=null,$operator='=',$escape=true){
        if(is_object($field)) $this->addCondition($field);
        else  $this->addWhere($field, $value, $operator, $escape, 'AND');
        return $this;
    }
    /**
     * Set the OR part of where ...
     * @param string/array $field - can be pairs key=>$value, for comparision will be used operator
     * @param value/null $value
     * @param string $operator - =, < , > , ...
     * @param boolean $escape  Should we escape the key and val,  for security ... yes
     * @return $this - for chaining
     */
    public function orwhere($field,$value=null,$operator='=',$escape=true){
        if(is_object($field)) $this->addCondition($field,'OR');
        else  $this->addWhere($field, $value, $operator, $escape, 'OR');
        return $this;
    }

    public function ornot($field,$value=null,$operator='=',$escape=true){
        if(is_object($field)) $this->addCondition($field,'OR NOT');
        else  $this->addWhere($field, $value, $operator, $escape, 'OR NOT');
        return $this;
    }

     public function andnot($field,$value=null,$operator='=',$escape=true){
        if(is_object($field)) $this->addCondition($field,'AND NOT');
        else  $this->addWhere($field, $value, $operator, $escape, 'AND NOT');
        return $this;
    }

    /**
     * AND like subsearch, fields will be joined in one AND substatement
     * @param string/array $fields - array of fields - just plain fields - this will be joined with OR
     * @param string $pattern Pattern to search ... like %smthing, test%, ...
     * @return $this
     */
    public function like($fields,$pattern){
        $this->addLike($fields, $pattern);
        return $this;
    }

     /**
     * AND NOT LIKE  subsearch, fields will be joined in one AND substatement
     * @param string/array $fields - array of fields - just plain fields - this will be joined with OR
     * @param string $pattern Pattern to search ... like %smthing, test%, ...
     * @return $this
     */
    public function notlike($fields,$pattern){
            $this->addLike($fields, $pattern,'AND', 'NOT LIKE');
            return $this;
    }

    /**
     *  OR like subsearch, fields will be joined in one OR substatement
     * @param string/array $fields - array of fields - just plain fields - this will be joined with OR
     * @param string $pattern Pattern to search ... like %smthing, test%, ...
     * @return $this
     */
    public function orlike($fields,$pattern){
        $this->addLike($fields, $pattern,'OR');
        return $this;
    }

     /**
     * OR NOT LIKE subsearch, fields will be joined in one AND substatement
     * @param string/array $fields - array of fields - just plain fields - this will be joined with OR
     * @param string $pattern Pattern to search ... like %smthing, test%, ...
     * @return $this
     */
    public function ornotlike($fields,$pattern){
            $this->addLike($fields, $pattern,'OR', 'NOT LIKE');
            return $this;
    }

    
    public function in($field,$values,$escape=true){
        if($escape){
            $field  = $this->db->escape_column($field);
            if( $escape && is_array($values)) foreach($values as $k=>$v) $values[$k] = $this->db->escape($v);
        }
        if(is_array($values)) $values = '( '.implode(', ',$values).' )'; else $values = "($values)";
        $this->addWhere($field,$values,'IN',false);
        return $this;
    }

    public function orin($field,$values,$escape=true){
        if($escape){
            $field  = $this->db->escape_column($field);
            if( $escape && is_array($values)) foreach($values as $k=>$v) $values[$k] = $this->db->escape($v);
        }
        if(is_array($values)) $values = '( '.implode(', ',$values).' )'; else $values = "($values)";
        $this->addWhere($field,$values,'IN',false,'OR');
        return $this;
    }




/*******
   PRIVATE FUNCTIONS
 */


    private function addCondition($condition,$type='AND'){        
        $this->filters[] = array('cond'=>$condition,'type'=>$type);
        return $this;
    }

    

    private function addLike($fields,$value, $type='AND', $operator = 'LIKE'){
        if(!is_array($fields)) $fields = array($fields);
        $c = condition::factory();
        foreach($fields as $f) $c->orwhere($f, $value, 'LIKE');
        $this->addCondition($c,$type);
    }
    

    private function addWhere($field,$value=null,$operator='=',$escape=true,$type='AND'){        
        if(!is_array($field)) $field = array($field=>$value); // want an array
        foreach($field as $k=>$v){
            if($escape) $k = $this->db->escape_column($k);
            if(!is_array($v)) $v = array($v);
            foreach($v as $val){
                if($escape) $val = $this->db->escape($val);
                $this->filters[] = array('field'=>$k,'operator'=>$operator,'value'=>$val,'type'=>$type);
            }
        }
    }

    






}
?>
