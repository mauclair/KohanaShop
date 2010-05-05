<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localizabletable
 *
 * @author snoblucha
 */
class LocalizableTable_Model extends Table_Model {
    public $language = 'cs';
    /**
     *Specifies if this model accepts/produces only translated fields. This means,
     * that any input fields will be translated into the transTable structure ::
     * eg. name => name_{$this->lang}. And also the output will contain only  translated
     * strings.
     * @var boolen
     */
    public $only_translated_bahaviour = true;
    protected $localized_table = '';
    protected $child = null;
    protected $localized_fields = array();
    protected $main_language = 'de';
    protected $isMainTable = false;


    public function __construct($language=null,$localizedFields=null,$table=null,$id=null) {
        parent::__construct($table, $id);
        if($language) $this->language = $language;
        if(!$language) $this->language = Session::instance()->get('lang',$this->parent_language);
        
        
        if($localizedFields) $this->localized_fields = $localizedFields;
        
        
        $this->isMainTable = ($this->language == $this->parent_language);

        $this->localized_table =  $this->table.(($this->isMainTable )? '':'_'.$this->language);
        

        if(!$this->isMainTable)$this->joins[] = array('table'=>$this->localized_table, 'field'=>$this->id,'type'=>'LEFT JOIN');
        $this->child = new Table_Model($this->localized_table,$this->id);
        
        // make sure we have localized fields
        if(empty($this->localized_fields)){
            $this->localized_fields =  $this->db->list_fields($this->table);
            unset($this->localized_fields[$this->id]);
        }

        if($this->only_translated_bahaviour  && !$this->isMainTable) {// set up output fields
            $fields = $this->db->list_fields($this->table);
            foreach($fields as $f=>$v){
                $lf = "{$f}_{$this->language}";
                if(in_array($f, $this->localized_fields))  $this->fields[] = "IF(LENGTH($lf)>0,$lf,$f) as $f"; else $this->fields[] = "`$f`";
            }
            
        }

        $this->_createTable($this->language);
        
        
    }
    /**
     *
     * @param String $lang
     * @param Array $fields Fields that will be contained in the table
     */
    public function _createTable($lang){
        if($this->isMainTable) return;
        if(!$this->db->table_exists($this->localized_table)){
            $fields = $this->db->field_data($this->table);
            $this->schema = array();
            foreach($fields as $k=>$v){
                if(in_array($v->Field,$this->localized_fields)) $this->schema[$v->Field.'_'.$lang] = $v->Type;
            }
            $this->createTable($this->schema, $this->localized_table);
        }
    }

    public function update(&$d){        
        if($this->isMainTable) {
            parent::update($d);             
        }
        else
            {
                if($this->only_translated_bahaviour){
                    foreach($this->localized_fields as $f ){
                        if(!isset($d[$f])) continue;
                        $lf = $f.'_'.$this->language;
                        $d[$lf] = $d[$f]; unset($d[$f]);
                        if(isset($this->validation[$f])) { // Oh! must validate localized field, let the child be responsible
                            $this->child->validation[$lf] = $this->validation[$f];
                            unset($this->validation[$f]);
                        }
                    }
                }
             
                parent::update($d);
                if(!$this->child->get($d[$this->id])) $this->child->add($d); else
                $this->child->update($d); // so we update our table, now the parent table changes will be promoted                
            }

    }

    public function add(&$d){
        if($this->isMainTable) {return parent::add($d); }
         else
            {
                $d[$this->id] = parent::add($d); // so we update our table, now the parent table changes will be promoted

                if($this->only_translated_bahaviour){
                    foreach($this->localized_fields as $f ){
                        $lf = $f.'_'.$this->language;
                        $d[$lf] = $d[$f]; unset($d[$f]);
                    }
                }
                $this->child->add($d);
            }
            return $d[$this->id];
    }

}
?>
