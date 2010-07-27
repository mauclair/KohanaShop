<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of basket
 *
 * @author snoblucha
 */
class Kosik_Controller extends Shop_Controller {
    public $basket;
    public function  __construct() {
        parent::__construct();
        $this->model = new Basket_Model();
    }

    public function index() {

        $v = View::factory('basket/index');
        $v->data = $this->model->get();

        if(!$v->data) $this->template->content = View::factory('basket/empty');
        else $this->template->content =  $v->render();
    }

    public function pridat() {
        $this->model->add($this->input->post());
        url::redirect($this->session->get('current-page'));
    }

    public function pridatKod() {
        $data = $this->input->post();
        $data['product_code'] = trim($data['product_code']);
        $pm = new Product_Model();
        if($data['product_code']) {
            $p = $pm->getPlain($data['product_code'],'product_code');
            if($p) {
                $this->model->addItem($p['product_id'],$data['count']);
            } else {
                error::add('basket.not-valid-product-code');
            }
        } else {
            error::add('basket.not-valid-product-code');
        }
        url::redirect($this->session->get('current-page'));
    }

    public function odebrat($id) {
        $this->model->remove($id);
        url::redirect('kosik');
    }

    public function prepocitat() {
        $p = $this->input->post();
        foreach($p['quantity'] as $k=>$v) {
            $this->model->modify($a = array('product_id'=>$k,'quantity'=>$v));
        }
        url::redirect('pokladna');
    }
}
?>
