<?php
class AdminBanner_Controller extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->model = new Banner_Model();
        $this->redirect_to = url::site('adminBanner/listBanners');
    }

    public function index(){
        $this->listBanners();
    }

    public function listBanners(){
        
        $this->iTemplate->content = View::factory('admin/banner/list')->set('banners',$this->model->fetch());
    }

    public function newBanner(){
        $cats = new BannerCategory_Model();
        $this->iTemplate->content = View::factory('admin/banner/new')
                                     ->set('banner_groups',$cats->getForSelect('bannerCategory_html_id', 'bannerCategory_name'));
    }

    public function edit($id){
        $cats = new BannerCategory_Model();
        $data = $this->model->get($id);
        $this->iTemplate->content = View::factory('admin/banner/edit')->set($data)
                                    ->set('banner_groups',$cats->getForSelect('bannerCategory_html_id', 'bannerCategory_name'))
                                    ->set('banner_item',View::factory('banner_item')->set($data)->render())
                                    ->render();
    }

    public function getItem($item_id){
        $this->iTemplate->content = View::factory('banner_item')->set($this->model->get($item_id))->render();
    }
}

?>
