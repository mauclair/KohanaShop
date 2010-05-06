<?php defined('SYSPATH') or die('No direct script access.');
 class Articles_Model extends LocalizableTable_Model{
        public $table = 'articles';
        public $id = 'article_id';        
        public $validation = array('article_title'=>array('required'),'article_text'=>array('required'));
        public $autoUrl = array('article_title'=>'article_url');

        protected $parent_language = 'de';
        protected $localized_fields = array('article_title','article_text');
	
	function add(&$d){
		$time =  time();
		$d['cdate'] = $time;
		$d['mdate'] = $time;
		parent::add($d);
	}

        public function update(&$d){
            $d['mdate'] = time();
            parent::update($d);
        }

 }

?>