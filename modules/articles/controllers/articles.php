<?php defined('SYSPATH') or die('No direct script access.');
class Articles_Controller extends My_Controller {
	public $template = 'mainTpl';
	public function __construct(){
		parent::__construct();						
		$this->model = new Articles_Model();
		$this->template->content = '';
                $girls = new Girls_Model();
                $this->template->footer = View::factory('girlFooter')->set('girls',$girls->fetch())->set('current_girl',$url_name='')->render();;
                $this->template->css = 'styles/articles.php';

                
	}

        public function  __call($name,  $arguments) {
                $a = $this->model->get($name,'article_url');
                if(!$a) throw new Kohana_404_Exception();
                $this->template->content = View::factory('article_detail')->set($a)->render();
                $this->template->title = $a['article_title'].' - '.$this->template->title ;
                ;
                
            }

        
    }

?>