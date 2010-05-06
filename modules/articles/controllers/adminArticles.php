<?php
    class AdminArticles_Controller extends Admin_Controller {
        public function __construct() {
            parent::__construct();
            $this->model = new Articles_Model();
            $this->redirect_to = 'adminArticles/listArticles';
            if(in_array($this->uri->segment(2),array('update','add','delete'))) $this->cache->delete_tag('articles');
       }

       public function listArticles(){
            $data = $this->model->fetch();
            $this->template->content = View::factory('admin/articles/list')->set('articles',$data)->render();
       }

       public function newArticle(){
            $this->template->content = View::factory('admin/articles/new');
       }

       public function edit($article_id){
            $this->template->content = View::factory('admin/articles/edit')->set($this->model->get($article_id))->render();
       }

    }

?>
