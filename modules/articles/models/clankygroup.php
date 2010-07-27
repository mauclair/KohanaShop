<?php defined('SYSPATH') or die('No direct script access.');
 class ClankyGroup_Model extends Table_Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'clanky_group';
		$this->id = 'clanky_group_id';
		$this->requiedFields = array('group_title');
		$this->uniqueFields = array('url');
		$this->hasPerms = false;
		$this->formDef = array(
							'parent_id'=>array(
										'table'=>'clanky_group',
										'type'=>'select',
										'dataField'=>'clanky_group_id',
										'showField'=>'group_title',
										'data'  => array(''=>'')
							)


		);

	}
	public function add(&$d){
		if (empty($d['url'])) {
			$d['url'] = url::title($d['group_title']);
		} else $d['url'] = url::title($d['url']);
		parent::add($d);
	}

 	public function update(&$d){
		if (empty($d['url'])) {
			$d['url'] = url::title($d['group_title']);
		} else $d['url'] = url::title($d['url']);
		parent::update($d);
	}
 }

?>