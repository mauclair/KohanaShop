<?php
class Pokladna_Controller extends Shop_Controller {
    public $model;
    public function __construct() {
        parent::__construct();
        $this->model = new Basket_Model();
        $this->content = new view('pokladna/index');
        $this->content->progress = new View('pokladna/progress');
    }

    public function index() {

        $b = new Basket_Model();


        $this->content->content = View::factory('basket/index')->set('data',$b->get())->set('sums',$b->sums())->render();
        $this->content->progress->set('pos',1);
    }

    public function _render() {
        $this->template->content = $this->content->render();
        parent::_render();
    }

    public function doprava() {
        $this->content->progress->set('pos',2);
        $ship_model = new Shipping_Model();
        $pay_model = new Pay_Model();
        $this->content->content = View::factory('pokladna/doprava')->set('shipping',$ship_model->fetch())->set('payment',$pay_model->fetch());

    }

    public function ulozDopravu() {
        $pokladna = $this->session->get('pokladna',array());
        $pokladna['doprava'] = $this->input->post();
        $this->session->set('pokladna',$pokladna);
        url::redirect('pokladna/adresa');
    }


    public function adresa() {
        $this->content->progress->pos = 3;
        $c= '';
        if(is::logged()) {
            $c=  View::factory('pokladna/adresa');
            $uinfo = new User_info_Model();
            $u = User_Model::getLogged();
            $uinfo->where('user_id', $u['user_id']);
            $c->set('addresses',$uinfo->fetch())->set('billing_address',$this->session->get('user'))->set($u);
        } else {
            $initialIndex = ($this->session->get('pokladna.shipping'))? 2 : 0;
            $c = View::factory('pokladna/adresa_notlogged')
               ->set('initialIndex',$initialIndex);
            $this->session->set('go-after-login','pokladna/adresa');

        }
        $this->content->content = $c->render();

    }

    public function bezRegistrace() {
        $this->content->progress = '';
        $ca = $this->session->get('pokladna.billing',Uzivatel_Controller::$clean_user);
        $this->content->content =  View::factory('pokladna/adresa')->set($ca)->set('billing_address',$ca)->set('addresses',array());
    }

    public function rekapitulace() {
        $this->content->progress->pos = 4;
        $this->content->content = 'TODO> REAKPITULACE';
        //todo: zobrazit vybran0 polozky
    }



    public function dokonceni() {
        //todo: ulozit objednavku,
    }

    public function ulozAdresy() {

        $fields = $this->input->post();
        $billing= array();
        $shipping = array();

        foreach($fields as $k=>$v) {
            if(strpos($k, 'shipping_')===false) {
                $billing[$k] = $v;
            } else {
                $k = str_replace('shipping_', '', $k);
                $shipping[$k] = $v;
            }
        }

        $required = array('address_1','city','zip','name');


        $validation_shipping = new Validation($shipping);
        $validation_billing = new Validation($billing);
        foreach($required as $v) {
            $validation_billing->add_rules($v, 'required');
            if($shipping) $validation_shipping->add_rules($v, 'required');
        }

        $pokladna = $this->session->get('pokladna',array());
        if($shipping) $pokladna['shipping'] = $shipping; //else unset($pokladna['shipping']);
        $pokladna['billing'] = $billing;
        $this->session->set('pokladna',$pokladna);

        $validation_billing->add_rules('email', 'valid::email','required');
        $validation_billing->add_rules('phone_1', 'numeric','required');


        if($validation_billing->validate() && (count($shipping)==0  || $validation_shipping->validate())) {
            url::redirect('pokladna/rekapitulace');
        } else {
            error::add(Kohana::lang('pokladna.address-not-valid'));
            error::parseValidation($validation_billing->errors());
            error::parseValidation($validation_shipping->errors());
            url::redirect('pokladna/adresa');
        }



    }

    public function shipAddressForm() {
        $id = (int)$this->input->post('user_info_id',-1);
        if($id<0) {
            $this->content->content = '';
            $this->content->progress = '';
            return;
        }
        $data = $this->session->get('pokladna.shipping',Uzivatel_Controller::$clean_user);
        if($id>0 ) { // load
            $uim = new User_info_Model();
            $data = $uim->get($id);
        }
        $this->content->progress ='';
        $this->content->content = View::factory('pokladna/address_form')->set($data)->set('prefix','shipping_');
    }




}
?>