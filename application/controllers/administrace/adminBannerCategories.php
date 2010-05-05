<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bannerCategories
 *
 * @author snoblucha
 */
class adminBannerCategories_Controller extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new BannerCategory_Model();
        $this->redirect_to = 'adminBannerCategories/listCategories';
    }

    public function index(){
        $this->listCategories();
    }

    public function newCategory(){        
        $this->template->content = View::factory('admin/bannerCategory/new');
    }

    public function edit($id){
        
        $this->template->content = View::factory('admin/bannerCategory/edit')->set($this->model->get($id));
                                      
    }

    public function listCategories(){
        $this->template->content = View::factory('admin/bannerCategory/list')->set('categories',$this->model->fetch());
    }


}
?>
