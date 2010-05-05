<?php
  class Category_Model extends Table_Model {
      public $table = 'category';
      public $autoUrl = array('category_name'=>'category_url');
      public function __construct() {
          parent::__construct();
          $this->joins[] = array('table'=>'product_category_xref', 'field'=>'category_id');
          //$this->joins[] = array('table'=>'product', 'table');
          $this->groupBy = 'category_id';
          $this->fields = array('category_id','category_name','category_url', 'COUNT(product_id) as product_count');
          $this->sortBy = 'vaha desc, category_name';
      }
      

  }

?>
