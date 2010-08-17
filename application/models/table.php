<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @property Condition_Core $where
 * @property Database_Core $db
 */
class Table_Model extends Model {
    public $table;
    public $id = 'id';
    /**
     *Define array of preview fields (can be used with table view) - Deprecated
     * @var array
     */
    public $preview = array();
     /**
     *Defines the where part of the query.
     * @var Condition
     */
    public $where  = null;
    
    /**
     *String which will be used in ORDER BY sql field
     * @var string
     */
    protected $sortBy;
    /**
     *Fields in query
     *
     * <code>
     * array('*',"DATE_FORMAT(date,'%c.%d.%e') as nice_date") results in SELECT *, DATE_FORMAT(...) ...
     * </code>
     * @var array
     */
    protected $fields  = array();

    public $limit   = array();
    /**
     *Table Join definitions
     *
     * * <code>$this->joins[] = array('table'=>'table_name','field'=>'table_id');  || array('table'=>'table_name','on'=>'t1.field1 = t2.field2');</code>
     * @var array     
     */
    protected $joins   = array();

   
    
    /**
     *Form definition field
     *
     * @var array
     */
    protected $formDef = array();
    /**
     *Defines auto url functionality, key means which key will be converted into url-sanitized string. If
     * the value of url-field already exists in database then -x is appended to the field  (like: in db then name, name-1, name-2,...)
     * @var array
     * @example array('name'=>'url_name')  - if url_name is empty then it is filled with url-cleaned string from name key of the passed-in array
     */
    public $autoUrl = array();
    /**
     *The same structure as filters, but for HAVING part of the query
     * @var Condition
     */
    public $having = null;
    /**
     *Group by string used in query builder
     * @var string
     */
    public $groupBy = '';
    /**
     * Validation array for fields, works with kohana validation library
     * @var array
     * @example array('field_name'=>array('required','valid::number'))
     */
    public $validation = array();
        

    public $baseQuery;
    /**
     *Variable for handling files upload. Keys define form/table fields, values defines
     *handling process as referred in Kohana docs upload helper class. Value in add/update array with
     * key will be set to uploaded filename
     *
     * <code>
     * array('filename'=>array('validate'=>array('upload::valid','upload::required'),'directory'=>'uploads','process'=>'functionToprocess'))
     *</code>
     * @var array definiton of the file processing
     */
    public $files = array();


     public static function factory($table='',$id=''){
         $class = get_class();
         return new $class($table,$id);
     }


    /**
     * Constructor
     * @param string $table Table name
     * @param string $id    Table id
     */
    public function __construct($table='',$id='') {
        if($table) $this->table=$table;
        if($id) $this->id=$id;
        else if($table)$this->id = $table.'_id';
        parent::__construct();
        $this->where = new condition();
        $this->having = new condition();
        $q = "SET  SESSION group_concat_max_len = 40840";
        $this->db->query($q);
    }


    public function getTable($offset=-1,$count=-1) {
        $olimit = $this->limit;
        if ($offset>=0) {
            $a = array();
            $a['offset'] = $offset;
            if ($count>0) $a['count'] = $count;

            $this->limit = $a;
        }
        $q = $this->getQuery();
        //echo $q;
        $query = $this->db->query($q);
        $this->limit = $olimit;
        return $query;
    }


    
    public function getQuery() {

        $fields = '';
        if ((is_array($this->fields) && count($this->fields)>0)  || !empty($this->fields) ) { // Get specified Fields or all
            //we could escape select fields, but there are many functions that are not supported
            //foreach($this->fields as $k=>$v) $this->fields[$k] = $this->db->escape_column($v);
            $fields = implode(', ',$this->fields);
        } else $fields = '*';
        
        

        $f = $this->where->get();
        $f = $f ? ' WHERE '.$f : '';
        $jn = '';
        $hav = $this->having->get();
        $hav = $hav ? ' HAVING '.$hav : '';

        foreach ($this->joins as $j) {
            //	if (!isset($j['table'])  || (!isset($j['field'])&&!isset($j['on']))) continue;
            $typ = (isset($j['type']))? ' '.$j['type'].' ' : ' JOIN ';
            $jn .= " $typ {$j['table']} ";
            if (isset($j['field']) && $j['field']) {
                $jn .=" USING ({$j['field']}) ";
            }
            if (isset($j['on']) && $j['on']) {
                $jn.= 'ON '.$j['on'].' ';
            }
        }
        $s = '';
        if($this->sortBy) $s = 'ORDER BY '.$this->sortBy;
        
        
        $gb = '';
        if (!empty($this->groupBy )) $gb = "GROUP BY {$this->groupBy}";
        $lim = '';
        $limit = $this->limit;
        if(!isset($limit['offset'])&&isset($limit['count'])) $limit['offset'] = 0;
        if ($limit && isset($limit['offset'])) {
            $lim = ' LIMIT '.$limit['offset'];
            if (isset($limit['count'])) $lim.=','.$limit['count'];      
        }


        $q = "SELECT $fields FROM {$this->table} $jn $f $gb $hav $s $lim";
        
        //echo $q;
        return $q;
    }

    /**
     * getForm - returns array of form elements, based on $definition and data $passed
     *
     * @param array $def
     * @param array $data
     */
    public function getForm($def=array(),$data = false) {

        if (empty($def) || count($def)==0) $def = $this->formDef; // pokud nemame definice z vnejsku pouzijem z vnitrku
        $f = $this->db->list_fields($this->table);
        $res = array();
        $idSuffix = (isset($data['id']))? '_'.$data[$this->id] : '';
        foreach($f as $k=>$v) {
            $value =  (isset($data[$k])) ? $data[$k] : '';

            $opts = array('name'=>$k,'id'=>$k.$idSuffix);

            $forValid = (isset($this->validation[$k]))
                ?'class="'.((is_array($this->validation[$k]))
                ?implode(' ',$this->validation[$k])
                : $this->validation[$k]).'"'
                : '' ;
            if ( isset($def[$k]) ) { // matched, do some job here
                $type = (isset($def[$k]['type'])) ? $def[$k]['type'] : 'text'; // abysme meli typ
                $this->getData($def[$k]);

                switch($type) {
                    case 'select':
                        $res[$k] = form::dropdown($opts,$def[$k]['data'],$value);
                        break;
                    case 'checkbox':
                        $opts['name'].='[]';
                        $topts = $opts;
                        foreach($def[$k]['data'] as $key=>$val) {
                            $topts['id'] =$opts['id'].'_'.$key;
                            $res[$k][$val]= form::checkbox($topts,$key,substr_count($value,$key)>0);
                            //TODO : tady by se to melo poradne promyslet ... jako pro Perms, dobry, ale pro neco jineho asi spis nespecifikovana hodnota
                        }
                        break;
                    case 'single_checkbox':
                        $res[$k] = form::checkbox($opts,$def[$k]['value'],$value==$def[$k]['value'],$forValid);
                        break;
                    case 'radio':
                        foreach($def[$k]['data'] as $key=>$val)
                            $res[$k][$val]= form::radio($opts,$key,($key==$value));
                        break;
                    case 'password':
                        $res[$k] = form::password($k,'',$forValid);
                        $res[$k.'_check'] = form::password($k.'_check');
                        break;
                    case 'hidden':
                        $res[$k] = form::hidden($k, $value);
                        break;

                    case 'textarea':
                        $res[$k] = form::textarea(array('name' => $k, 'rows' => '10', 'cols'=>'30'),$value);
                        break;
                    case 'none':
                        ;
                        break;
                    case 'raw-text':
                        $res[$k] = $value;
                        break;
                    case 'date' :
                        $res[$k] = form::input($opts, $value,$forValid);
                        $res[$k].= form::button(array('name'=>'cal','id'=>'cal','onclick'=>"displayCalendar(document.getElementById('$k'),'dd.mm.yyyy',this);return(false);"),'cal');
                        break;
                    default:
                        $res[$k] = 'UNKNOWN??ERROR??';
                        break;

                }

            }
            else {

                $res[$k] =  ($k==$this->id) ? form::hidden($this->id, $value) :form::input($opts, $value,$forValid);
            }
        }
        if (!$data || !isset($data[$this->id])) unset($res[$this->id]);
        return $res;

    }

    /**
     * Returns data for Form Def or just use as special get for select method
     *
     * @param array $data :fields [data]=>data, data from def will be appended to this field,
     * 							  ['showField'] =>'what will be the values field,
     *							  ['dataField'] =>'what will be the key fields,
     * 							  ['table'] => table,
     * 							  ['orderBy'] => order by
     * 					          ['where']=> plain where string
     */

    public function getData(&$data) {

        $data['data'] = !isset($data['data']) ? array() :  $data['data']; // to have array
        $showF  = (!isset($data['showField'])) ? $this->id : $data['showField'];
        $dataF  = (!isset($data['dataField'])) ? $this->id : $data['dataField'];
        $where  = (!isset($data['where'])) ? '' :  ' WHERE '.$data['where'];
        $orderBy = (!isset($data['orderBy'])) ? ' ORDER BY '.$showF :  ' ORDER BY '.$dataF;
        ;
        //TODO: poradne to tady dodelat, razeni, do where pole atd.

        if ( isset($data['table']) ) {
            $cols = ($showF!=$dataF) ? " $showF, $dataF " : " $dataF ";
            $q = "SELECT $cols FROM {$data['table']} $where $orderBy";
        }
        else if (isset($data['query'])) {
            $q = $data['query'];
        }
        else {
            return ;
        }
        $dbres = $this->db->query($q);
        foreach($dbres->result(false) as $row) {
            $data['data'][$row[$dataF] ]= $row[$showF];
        }

    }

    private function hasFields() {
        if(count($this->fields)==0 && !empty($this->table)) {
            $fields =$this->db->list_fields($this->table);
            $this->fields = array_keys($fields);
            //foreach($fields as $k=>$v){$this->fields[] = $k;	}
        }
    }

    public function getPreviewFields() {
        $this->hasFields();
        if (count($this->preview)==0 ) {
            $this->preview = $this->fields;
            unset ($this->preview[0]);
        }
        return $this->preview;
    }

    public function update(&$d, $idkey = false) {
        if(!$idkey) $idkey = $this->id;
        $this->validation[$idkey] = array('required');
        $dat =  array_intersect_key($d,$this->db->list_fields($this->table));
        if (count($this->autoUrl)>0) foreach($this->autoUrl as $k=>$v) $this->makeUrl($dat,$v,$k);
        //if ($this->hasPerms) $this->parsePerms($dat);
        if(count($this->files)>0)$this->processFiles($dat);
        if (!$this->validate($dat)) return false;
        if ( !isset($dat[$idkey]) ) {
            return false;
        }
        $id = $dat[$idkey];
        unset($dat[$idkey]);
        unset($this->validation[$idkey]);
        if(!$dat) return false;
        $d = array_merge($d, $dat);
        $this->db->update($this->table,$dat,array($idkey => $id));
        return true;


    }

    
    public function add(&$d) {
        $dat =  array_intersect_key($d,$this->db->list_fields($this->table));

        if (count($this->autoUrl)>0) foreach($this->autoUrl as $k=>$v) $this->makeUrl($dat,$v,$k);
        //if ($this->hasPerms) $this->parsePerms($dat);
        if(count($this->files)>0) $this->processFiles($dat);
        if (!$this->validate($d)) return false;
        $res = $this->db->insert($this->table,$dat);
        return $res->insert_id();
    }

    /**
     * Returns data from table
     *
     * @param array/string $id
     * @param string $field
     * @param boolean $multi if it shoud return more than one line
     * @return array/query object
     */
    public function get($id=false,$field=false,$multi=false) {
        if (!$field) $field=$this->id;
        $owhere = $this->where;
        if($id || $id !== false)
            if (!is_array($id)) {
                $this->where->where($field,$id);
            }
            else {
                foreach($id as $k=>$v) {
                    if(is_object($v)) $this->where->where($v);
                    else $this->where->where($k, $v);
                }
            }
        $q = $this->db->query($this->getQuery());
        kohana::log('error', $this->getQuery());
        $this->where = $owhere;
        if ($multi) return $q;
        else return $q->result(false)->current();
    }

    /**
     * Returns plain line from table
     * @param int/string $id
     * @param string $field
     * @return array
     */
    public function getPlain($id=false,$field=false) {
        if(!$id) return false();
        if(!$field) $field = $this->id;
        $q = $this->db->query("SELECT * FROM {$this->table} WHERE $field='$id'");
        return $q->result(false)->current();
    }



    public function validate(&$a,$adding = true) {

        if(count($this->validation)>0) {
            $va = new Validation($a);
            // DO validation via Validation class
            foreach($this->validation as $k=>$v) {
                if (is_string($v)) {
                    $va->add_rules($k,$v);
                }
                else if(is_array($v)) {
                    foreach($v as $val) {
                        if ($val == 'unique') { // must be unique field => must add special callback
                            $va->add_callbacks($k,array($this,'is_unique'));
                        }
                        else 	$va->add_rules($k,$val);
                    }
                }
            }
            if (!$va->validate()) {
                $err  = $va->errors();
                foreach($err as $k=>$v) {
                    error::add(''.Kohana::lang($this->table.'.'.$k).' - '.Kohana::lang('errors.'.$v));
                }
                return false;
            }
            else {
                return true;
            }
        }

        if (isset($this->requiedFields) || isset($this->uniqueFields)) error::add('BACHA SPOLEHA SE NA STAREJ VALIDOVACI SYSTEM');
        return true;
    }
    /**
     * Deletes all lines form table with given pair $field = '$id'
     * @param int/string $id
     * @param string $field
     */
    public function delete($id,$field='') {
        $field = (empty($field))? $this->id : $field;
        if(count($this->files)>0) $this->processDeleteFiles($id, $field);
        $this->db->delete($this->table, array($field=>$id) );
    }

    public function count() {
        $of = $this->fields;
        $this->fields = array('count(*) as c');
        $q = $this->getQuery();
        $this->fields = $of;
        $res = $this->db->query($q);
        if(count($res)==0) return 0;
        $res = $res->current()->c;
        return $res;
    }

    public function getForSelect($data,$desc,$free_line=false,$where=false,$default='') {

        $data = array('table'=>$this->table,'dataField'=>$data,'showField'=>$desc);
        if ($where) $data['where'] = $where;
        if ($free_line) {
            $data['data'] = array(''=>$default);
        }
        $this->getData($data);
        return $data['data'];
    }

    public function createTable($schema = false,$table_name = false) {
        if (!$schema ) $schema = $this->schema;
        if (!$table_name ) $table_name = $this->table;
        $sql = 'CREATE TABLE `'.$table_name.'` (';
        $sql.= "`{$this->id}` int NOT NULL auto_increment ";
        foreach($schema as $k=>$v) {
            if ($k=='__KEYS__') {
                $sql.=", $v ";
            }
            else
                $sql.=", `{$k}` $v ";
        }
        $sql.=", PRIMARY KEY  (`{$this->id}`) );";
        $this->db->query($sql);
    }

    public function recreateTable($schema = false,$table_name = false) {
        if (!$schema ) $schema = $this->schema;
        if (!$table_name ) $table_name = $this->table;
        $sql = "DROP TABLE `$table_name`;";
        $this->db->query($sql);
        $this->createTable($schema,$table_name);
    }

    public function checkTable() {
        if (Kohana::config('main.table-checking') && !$this->db->table_exists($this->table)) {
            $this->createTable();
            return false;
        }
        return true;
    }

    public function makeUrl(&$d,$url_field,$from_field) {
        if(!isset($d[$from_field])) return;
        if (!isset($d[$url_field])) $d[$url_field] = '';

        $un = $d[$url_field];

        $un = (empty($un)) ? url::title($d[$from_field] ) : url::title($d[$url_field] );

        $res = $this->get($un,$url_field);
        $i = 1;
        $exists = ($res && ( !isset($d[$this->id]) || $res[$this->id] != $d[$this->id] ));
        $test = $un;
        while($exists) {
            $test = $un.'-'.$i;
            $res = $this->get($test,$url_field);
            $exists = ($res && (!isset($d[$this->id]) || $res[$this->id] != $d[$this->id] ));
            if (!$exists) break;
            $i++;
        }
        $d[$url_field] = $test;
    }
    

    public function is_unique(Validation $array, $field) {
        $odata = false;
        if (isset($array[$this->id]))$odata = $this->get($array[$this->id]);
        $udata = $this->get($array[$field],$field);

        if ($udata) {
            if ($odata && $odata[$field] == $udata[$field]) {
                return; // already in the table, but unchanged
            }
            $array->add_error($field,'unique');
        }
        else error::add(print_r($udata,true));

    }

    public function apply_filters($filters) {
        if (!is_array($filters)) return false;
        foreach($filters as $k=>$v) {
            $this->filter[] = array($k=>$v);
        }
        return $this;
    }

    public function apply_search($string, $field = '', $def='%%%s%%', $search_label = 'search') {
        if (!$string) return;
        if(!is_array($field)) {
            if (is_string($def)) $def = array($field=>$def);
            $field = array($field);

        }
        $default = '%%%s%%';
        foreach($field as $f) {
            $like = (isset($def[$f])) ? $def[$f] : $default;
            $this->filter[$search_label][$f] = array('value'=>sprintf($like,$string),'operator'=>' LIKE ');
        }
        return $this;
    }
    /**
     * Add filter to the query. Will be applied in WHERE part of the query.
     * @param string $field - on which field
     * @param string/number $value - to filter
     * @param operator $operator - default =
     * @param boolean $dontEscape - don't escape values
     * @param  string/number $label - you can add label to the filter, to use it in advance - suport for this behaviour is incomplete
     * @return $this -  therefore it is chainable
     *
     * @example Simple : $table->where->where('image_id',16) <=> WHERE image_id = '16'
     * @example Advanced : $table->where->where('image_id','(SELECT image_id FROM image_tag WHERE tag_id = '16')', 'IN', false)
     * <=> WHERE image_id IN (SELECT ...)
     * @example Avoid processing: $table->where->where('image_id IN (....)',false,false,false)-> just use the first string in WHERE
     
    public function where->where($field,$value,$operator=false,$dontEscape=false) {
        $this->where->where($field,$value,$operator,$dontEscape);
        return $this;
    }*/

    public function limit($offset,$limit=false) {
        if(!$limit) {$limit=$offset; $offset = 0;} // not spec limit ... assume that user mens  LIMIT 0,x
        $this->limit = array('offset'=>$offset,'count'=>$limit);
        return $this;

    }
    /**
     *Returns the selected data *
     * @return Database_Result
     */
    public function fetch() {
        return  $this->db->query($this->getQuery());
    }

    public function query($q) {
        return $this->db->query($q);
    }

    /**
     * Process Files with respect to $this->files array.
     * @param POST array $d
     */
    public function processFiles(&$d) {
        foreach($this->files as $k=>$v) {
            $dir = isset($v['directory']) ? $v['directory'] : DOCROOT.'upload';

            $files = new Validation($_FILES);
            if(isset($v['validate'])) foreach($v['validate'] as $rule)$files->add_rules($k, $rule );
            if((!isset($v['validate'])) || $files->validate()) {
                $d[$k]=upload::save($k,NULL,$dir,FALSE);
                if(isset($v['process'])) call_user_func($v['process'], $d[$k]);
            }
            else {
                //error::parseValidation($files->errors());
                //unset($d[$k]);
            }
        }
    }

    /**
     *Searches all results and deletes specified files in $files array
     * @param string/int $id
     * @param string $field
     */
    private function processDeleteFiles($id,$field) {
        $this->where->where($field,$id);
        $res = $this->fetch();
        foreach($res as $line) {
            $line = (array)$line;
            foreach($this->files as $k=>$v) {
                if(!isset($line[$k]) || empty($line[$k])) continue;
                if( file_exists($line[$k])) unlink($line[$k]);
            }
        }
    }

    /**
     * Set the order falg on the table
     * @param string/array $order - like 'name DESC, email asc,address desc', or array('name','desc')
     * @param string $direction - direction if only a field in $order is specified
     * @return $this
     */
    public function orderBy($order,$direction=null){
        if(is_array($order) && count($order)==2) $order = implode(' ',$order);
        if(is_string($order)) $order = explode(',',$order); // so we have not more of it
        if(count($order)==1 && $direction) $order[0] .= ' '.$direction;
        $orderStr = '';		
			
        foreach($order as $k=>$v) {
            $v = explode(' ',$v);//explode and escape first the name of the field
            if($orderStr) $orderStr.=', ';
            $orderStr .= $this->db->escape_column(trim($v[0]));
            if(isset($v[1])){
                //check if we have an allowed modificator;
                $v[1] = strtoupper(trim($v[1]));
                if(in_array($v[1],array('ASC', 'DESC', 'RAND()', 'RANDOM()', 'NULL')) ) $orderStr .= ' '.$v[1];
            }           

        }
        $this->sortBy = $orderStr;
        return $this;
    }
/**
 *
 * @param string $table - can be just string or subselect.
 * @param string $field -  the field parameter used in USING(...) statement. This parameter is escaped
 * @param string $type  - type f join [JOIN(default)|LEFT JOIN|....]
 * @param <type> $on
 * @return <type>
 */
    public function join($table,$field,$type='JOIN',$on=false){

        //sanitize type - could be, but it is not necessaty,
        //if the value is not permited by SQL then the error will already ocur
        $type = strtoupper(trim($type));
        //if(!in_array($type,array('LEFT JOIN','RIGHT JOIN','NATURAL JOIN','JOIN','INNER JOIN','CROSS JOIN','...')))


        //sanitize $on
        if($on){
            $on = explode('=',$on);
            if(count($on)==2){
                $on[0] = $this->db->escape_column(trim($on[0]));
                $on[1] = $this->db->escape_column(trim($on[1]));
                $on = implode('=',$on);
            } else {
                throw new Kohana_Exception('ON field must be like table1.field1=table2.field2');
            }
        }

        if($field){ // must care about escaping field USING statement with many fields
            $field = explode(',',$field);
            foreach($field as $k=>$v){
                $field[$k] = $this->db->escape_column(trim($v));
            }
            $field  = implode(', ',$field);
        }

        $this->joins[] = array('table'=>$table, 'field'=>$field,'type'=>$type,'on'=>$on);
        return $this;
    }

    public function where($field,$value,$operator='=',$escape=true){
            $this->where->where($field, $value, $operator, $escape);
            return $this;
    }

   public function __call($method,$args){
        if($method=='and') {
            return call_user_func_array(array($this->where,'where'), $args);

        } else if ($method=='or'){
            return call_user_func_array(array($this->where,'orwhere'), $args);
        } else if($method == 'andnot'){
            return call_user_func_array(array($this->where,'andnot'), $args);
        } else if($method=='ornot'){
            return call_user_func_array(array($this->where,'ornot'), $args);
        } else throw new Exception('METHOD NOT FOUND');

    }

/**
 * Set the fields in select
 * @param string/array $fields  - list of fields to select
 * @return $this
 */
    public function select($fields='*'){
        if(!is_array($fields)) $fields = func_get_args();
        $this->fields = $fields;
        return $this;

    }

    public function updateUrls(){
        $m = Table_Model::factory($this->table,$this->id);
        $data = $m->fetch();
        set_time_limit(0);
        foreach($data as $p){
            $t = (array)$p;
            foreach($this->autoUrl as $k=>$v) $t[$v] = url::title($t[$k]);
            $m->update($t);
            unset($t);
        }

    }

}
?>