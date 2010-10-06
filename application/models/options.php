<?php
/**
 * Options model, Cares about specific-site options. Can be/is localizable
 */
  class Options_Model extends LocalizableTable_Model{
        protected $localized_fields = array('value');
        protected $parent_language = 'de';
        public $table = 'options';
        public $id = 'option_id';
        public static $cachable = true;

  	private static $instance = NULL;
        private static $config = NULL;
        private static $cache = NULL;


  	public function __construct() {
  		parent::__construct();		
		$this->schema = array(
			'key'=>'varchar(128)',
			'group'=>'varchar(128)',
			'value'=>'varchar(255)',
		);
		$this->checkTable();                
  	}
        /**
         * Returns values from database ...
         * It first looks into database, if no record is found for given key then
         * the value is taken from options config file config/options.php.
         *
         * @param string $key - key to retrieve
         * @return string
         */
  	public static function ret($key){                
                if(self::$cachable){
                    $lang = Session::instance()->get('lang');
                    if(!self::$cache || !isset(self::$cache[$lang])) self::init_cache();
                    
                    if(isset(self::$cache[$lang][$key])) return self::$cache[$lang][$key];
                    
                }

                if(Options_Model::$config==NULL) Options_Model::$config = Kohana::config('options');
                if (Options_Model::$instance==NULL) Options_Model::$instance = new Options_Model();
		$res = Options_Model::$instance->get($key,'key');
                $res = (!$res ) ? Options_Model::$config[$key] : $res['value'] ;
                return $res;
  	}

        /**
         * Sets the option $key with value $val. Language is autodetected, cinternal cache cleared.
         * @param string $key - key to set
         * @param mixed $val - value
         * @param string $group - group. Currently unused
         */
  	public static function set($key,$val,$group=''){
                if(self::$cachable) {Cache::instance()->delete_tag('options'); self::$cache = null;}
                if(Options_Model::$config==NULL) Options_Model::$config = Kohana::config('options');
		if (Options_Model::$instance==NULL) Options_Model::$instance = new Options_Model();
		$res = Options_Model::$instance->get($key,'key');
		if ($res){
			Options_Model::$instance->update($d = array('option_id'=>$res['option_id'],'key'=>$key,'value'=>$val,'group'=>$group));
		} else {
			Options_Model::insert($key,$val,$group);
		}

  	}
        /**
         * Hard insert into the database. Mainly used in Options_Model::set method.
         * Should not be used unless you really know what are you doing, use Set mehtod instead.
         * @param String $key - key indentifier
         * @param String $val - value
         * @param String $group - group
         */
  	public static function insert($key,$val,$group=''){
  	    if (Options_Model::$instance==NULL) Options_Model::$instance = new Options_Model();
		$res = Options_Model::$instance->get($key,'key');
		if (!$res){
			Options_Model::$instance->add($d = array('key'=>$key,'value'=>$val,'group'=>$group));
		} else error::Add('options.key-already-exists');
  	}

        /**
         * Returns complete set of the options
         * @return Array -  [key]=>STDObject with key and  value properties
         */
        public function fetch(){
            $defaults = Kohana::config('options');
            $fetchres = parent::fetch();
            $res = array();
            foreach($fetchres as $v){
                $res[$v->key] = $v;
            }
            foreach($defaults as $k=>$v){
                if(!isset($res[$k])) {
                    $res[$k]->key = $k;
                    $res[$k]->value= $v;
                }
            }
            
            return $res;
        }

        private static function init_cache(){
            if(! self::$cache ) {
                $lang = Session::instance()->get('lang','de');
                $cache_key = "options.$lang";
                if(!isset(self::$cache['lang'])) {
                    $cacheM = Cache::instance();
                    $vals =  $cacheM->get($cache_key);
                    if(!$vals){
                        $om = new Options_Model();
                        $dbres = $om->fetch();

                        foreach($dbres as $row){
                            $vals[$row->key]=$row->value;
                        }
                        $cacheM->set($cache_key, $vals, array('options',$lang));
                    }
                    self::$cache[$lang] = $vals;
                }
                
            }
        }


  }
?>