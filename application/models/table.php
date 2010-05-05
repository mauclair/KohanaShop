<?php defined('SYSPATH') or die('No direct script access.');
class Table_Model extends Model {
    public $table;
    public $id = 'id';
    public $preview = array();
    public $filter  = array();
    public $sortBy  = array();
    public $fields  = array();
    public $limit   = array();
    public $joins   = array();
    public $where   = array();
    public $formDef = array();
    public $autoUrl = array();
    public $having = array();
    public $groupBy = '';
    public $validation = array();
    public $sortByOrder;
    public $hasPerms  = false;
    public $baseQuery;


    public function __construct($table='',$id='') {
        if($table) $this->table=$table;
        if($id) $this->id=$id;
        else if($table)$this->id = $table.'_id';
        parent::__construct();
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
            $fields = implode(', ',$this->fields);
        }
        else $fields = '*';
        $f = $this->filtersToString($this->filter);
        $f = empty ($f) ? $f : ' WHERE '.$f;
        $jn = '';
        $hav = $this->filtersToString($this->having);
        $hav = empty ($hav) ? $hav : ' HAVING '.$hav;

        foreach ($this->joins as $j) {
            //	if (!isset($j['table'])  || (!isset($j['field'])&&!isset($j['on']))) continue;
            $typ = (isset($j['type']))? ' '.$j['type'].' ' : ' JOIN ';
            $jn .= " $typ {$j['table']} ";
            if (isset($j['field'])) {
                $jn .=" USING ({$j['field']}) ";
            }
            if (isset($j['on'])) {
                $jn.= 'ON '.$j['on'].' ';
            }
        }

        if (( is_array($this->sortBy) &&  count($this->sortBy) > 0 ) || !empty($this->sortBy)) { // make Sort string from Array
            $s = '';
            if (is_array($this->sortBy))	foreach($this->sortBy as $v)	$s.= (empty($s) ? '' : ', ')."$v";
            else $s=''.$this->sortBy;
            $s = 'ORDER BY '.$s;
            $s.= ' '.$this->sortByOrder;
        }
        else $s = '';
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
        if ($this->hasPerms) $this->parsePerms($dat);
        if (!$this->validate($dat)) return false;
        if ( !isset($dat[$idkey]) ) {
            return false;
        }
        $id = $dat[$idkey];
        unset($dat[$idkey]);
        unset($this->validation[$idkey]);

        $this->db->update($this->table,$dat,array($idkey => $id));
    }
    public function add(&$d) {
        $dat =  array_intersect_key($d,$this->db->list_fields($this->table));
        if (count($this->autoUrl)>0) foreach($this->autoUrl as $k=>$v) $this->makeUrl($dat,$v,$k);
        if ($this->hasPerms) $this->parsePerms($dat);
        if (!$this->validate($d)) return false;

        $res = $this->db->insert($this->table,$dat);
        return $res->insert_id();
    }
    
    public function parsePerms(&$d) {
        if (isset($d['perms']) && is_array($d['perms']) ) {
            $d['perms'] = implode('',$d['perms']);
        }
        if (!isset($d['perms'])) $d['perms'] = NULL;
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
        $oFilter = $this->filter;
        if($id || $id !== false)
            if (!is_array($id)) {
                $this->filter[] = array($field=>$id);
            }
            else {
                foreach($id as $k=>$v) {
                    $this->filter[] = array($k=>$v);
                }
            }
        $q = $this->db->query($this->getQuery());
        $this->filter = $oFilter;
        if ($multi) return $q;
        else return $q->result(false)->current();
    }

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

    public function delete($id,$field='') {
        $field = (empty($field))? $this->id : $field;
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

    public function filtersToString(&$d) {
        $f = '';
        foreach ($d as $filter) {
            $f .= (empty($f)) ? '' : ' AND ';
            $f.='( ';
            $first = true;
            foreach($filter as $k=>$v) { // make Filter string from Filter Array
                $f.=(!$first) ? ' OR ' : '';
                $first = false;
                if (is_array($v)) {
                    if (!isset($v['no-escape'])|| $v['no-escape']==false) {
                        $v['value']=$this->db->escape($v['value']);
                    }
                    $f .= " ".$k.$v['operator']."".$v['value']." ";
                }
                else {
                    $f .= " ".$k."=".$this->db->escape($v);
                }
            }
            $f.=')';
        }
        return $f;

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

    public function addFilter($field,$value,$operator=false,$dontEscape=false,$label=false) {
        $data =array();
        if (!$operator) $data= array($field=>$value);
        else {
            $data = array($field=>array('operator'=>$operator,'value'=>$value));
            if ($dontEscape) $data[$field]['no-escape']=true;
        }
        if(!$label) $this->filter[] = $data;
        else $this->filter[$label]=$data;

        return $this;
    }

    public function limit($offset,$limit) {
        $this->limit = array('offset'=>$offset,'count'=>$limit);
        return $this;

    }

    public function fetch() {
        return  $this->db->query($this->getQuery());
    }

    public function query($q){
        return $this->db->query($q);

    }

}
?>