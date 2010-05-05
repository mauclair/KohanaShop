<?php
  class Produkt_Controller extends Shop_Controller {
      public function __construct() {
          parent::__construct();
          $this->model = new Product_Model();
      }

      public function  __call($name,  $arguments) {
         $p = $this->model->get($name,'product_url');
         if($p){
             $cm = new Category_Model();

             $this->template->content = View::factory('product/detail')
                            ->set($p)
                            ->set('atributes',Table_Model::factory('product_attribute')
                                                    ->where('product_id',$p['product_id'])
                                                    ->fetch()
                                  )

                            ->set('categories',$cm->forProduct($p['product_id']))
                            ->render();
         } else throw new Kohana_404_Exception();

      }

      public function updateUrls(){
        $this->model->updateUrls();
        Cache::instance()->delete_tag('products');
      }


  }
?>
