<?php

/**
 * @property Product_Model $model
 */
class AdminProducts_Controller extends Administrace_Controller {

    public function __construct() {
        parent::__construct();
        $this->model = new Product_Model();
        $this->redirect_to = $this->session->get('current-page');
    }

    public function index() {
        url::redirect('administrace/adminProducts/seznam');
    }

    public function seznam() {
        $default_filter = array('product_publish' => false, 'vendor_id' => false, 'category_id' => false, 'indikace_id' => false, 'product_special' => false);
        $filters = $this->session->get('administrace/adminProducts.filters', $default_filter);
        $this->model->apply_filters($filters);
        $sort = $this->session->get('administrace/adminProducts.sort', array('field' => 'product_name', 'desc' => 'asc'));
        $this->model->orderBy($sort['field'], $sort['desc']);
        $count = $this->model->fetch()->count();
        $pagination = new Pagination(array('total_items' => $count, 'base_url' => 'administrace/adminProducts/seznam/', 'uri_segment' => 'strana'));
        $offset = $pagination->sql_offset;

        //$this->model->apply_search($string)
        $this->model->limit($offset, $pagination->items_per_page);


        $v = View::factory('admin/products/table');
        $v->sort = $sort;
        $v->set('pagination', $pagination->render('digg'));
        $v->filters = $filters;
        $v->vendors = Table_Model::factory('vendor', 'vendor_id')->getForSelect('vendor_id', 'vendor_name', true);
        $v->data = $this->model->fetch();
        $this->template->content = $v->render();
    }

    public function edit($product_url) {
        $product = $this->model->get($product_url, 'product_url');
        if (!$product)
            url::redirect('administrace/adminProducts');
        $view = View::factory('admin/products/edit');
        $view->set($product);
        $mVendor = new Vendor_Model();
        $view->vendors = $mVendor->getForSelect('vendor_id', 'vendor_name', true);

        $view->details = $this->product_details($product['product_id'], false);
        $view->tags = $this->indikace($product['product_id'], false);
        $view->categories = $this->categories($product['product_id'], false);
        $view->images = '';

        $this->template->content = $view->render();
    }

    public function indikace($product_id, $set_content = true) {
        $indikace = new Tag_Model();
        $res = View::factory('admin/products/tags')
                        ->set('tags', $indikace->getTags((int) $product_id))
                        ->set('product_id', $product_id)
                        ->set('tag_select', $indikace->getForSelect('indikace_id', 'indikace_name', true, "indikace_id NOT IN (SELECT indikace_id FROM indikace_xref WHERE product_id='$product_id')"))
                        ->render();
        if ($set_content

            )$this->template->content = $res; else
            return $res;
    }

    public function categories($product_id, $set_content = true) {
        $categories = new Category_Model();
        $res = View::factory('admin/products/categories')
                        ->set('categories', $categories->forProduct((int) $product_id))
                        ->set('product_id', $product_id)
                        ->set('categories_select', $categories->getForSelect('category_id', 'category_name', true, "category_id NOT IN (SELECT category_id FROM product_category_xref WHERE product_id='$product_id')"))
                        ->render();
        if ($set_content

            )$this->template->content = $res; else
            return $res;
    }

    public function product_details($product_id, $set_content = true) {
        $details = new Product_details_Model();
        $details->where('product_id', $product_id);
        $res = View::factory('admin/products/details')->set('details', $details->fetch())->render();
        if ($set_content

            )$this->template->content = $res; else
            return $res;
    }

    public function removeTag($product_id, $tag_id) {
        $pcm = new Table_Model('indikace_xref', '');

        $pcm->where('product_id', $product_id)->where('indikace_id', $tag_id);
        $record = $pcm->fetch();
        if ($record->count() < 1) {
            error::add('product.tag-not-found');
        } else {
            $pcm->delete(array('indikace_id' => $tag_id, 'product_id' => $product_id));
        }
        $this->goBack();
    }

    public function addTag() {
        $indikace_id = $this->input->post('indikace_id');
        $product_id = $this->input->post('product_id');
        if ($product_id && $indikace_id) {
            $data = array('indikace_id' => $indikace_id, 'product_id' => $product_id);
            $model = new Table_Model('indikace_xref', '');
            if ($model->get($data)) {
                error::add(Kohana::lang('product.already-in-tags'));
            } else {
                $model->add($data);
            }
        }
        $this->goBack();
    }

    public function removeCategory($product_id, $category_id) {
        $pcm = new Table_Model('product_category_xref', '');
        $pcm->where('product_id', (int) $product_id);
        $c = $pcm->count();
        if ($c < 2) {
            error::add(Kohana::lang('product.must-be-in-category'));
        } else {
            $pcm->where('category_id', $category_id);
            $record = $pcm->fetch();
            if ($record->count() < 1) {
                error::add('product.category-not-found');
            } else {
                $pcm->delete(array('category_id' => $category_id, 'product_id' => $product_id));
            }
        }
        $this->goBack();
    }

    public function addCategory() {
        $category_id = $this->input->post('category_id');
        $product_id = $this->input->post('product_id');
        if ($product_id && $catagory_id) {
            $data = array('category_id' => $category_id, 'product_id' => $product_id);
            $model = new Table_Model('product_category_xref', '');
            if ($model->get($data)) {
                error::add(Kohana::lang('product.already-in-category'));
            } else {
                $model->add($data);
            }
        }
        $this->goBack();
    }

    public function detailsUpdate() {
        $model = new Table_Model('product_details', 'id');
        $model->update($this->input->post());
        $this->goBack();
    }

}

?>
