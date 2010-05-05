<?php
  class Category_Model extends Table_Model {
      public $table = 'category';
      public $id = 'category_id';
      public $autoUrl = array('category_name'=>'category_url');
      public function __construct() {
          parent::__construct();
          $this->join('product_category_xref', 'category_id');
          $this->join('product', 'product_id');
          $this->groupBy = 'category_id';
          $this->fields = array('category_id','category_name','category_url', 'COUNT(product_id) as product_count');
          $this->sortBy = 'vaha desc, category_name';
      }

       public function forProduct($product_id){
        $tm = new Table_Model('product_category_xref');
        $tm->join('category', 'category_id')->where('product_id',$product_id);
        return $tm->fetch();
    }

    public function updateUrls(){
        $data = $this->fetch();
        foreach($data as $c){
            $c = (array)$c;
            $c['category_url'] = url::title($c['category_name']);
            $this->update($c);
        }
    }
      

  }

?>
