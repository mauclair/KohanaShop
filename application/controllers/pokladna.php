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
        $sa = $this->session->get('pokladna.shipping');
        $address_selector = $this->session->get('pokladna.address_selector');
        
        $shipping_address = ($sa && $address_selector > -1 && $address_selector!==false) ?
                            View::factory('pokladna/address_form')->set($sa)->set('prefix','shipping_') : '';
        
        $this->content->content =  View::factory('pokladna/adresa')
                                    ->set($ca)
                                    ->set('billing_address',$ca)
                                    ->set('addresses',array())
                                    ->set('shipping_address',$shipping_address)
                                    ->set('shipping_address_id',$address_selector)
                                ;

    }

    public function rekapitulace() {
        if(!$this->session->get('pokladna')) url::redirect('pokladna');
        $this->content->progress->pos = 4;
        
        $basketModel = new Basket_Model();
        $shippingModel = new Shipping_Model();
        $shipType = $shippingModel->get($this->session->get('pokladna.doprava.shipping_id'));
        


        $basket = View::factory('basket/readOnly')->set('data',$basketModel->get())->set('sums',$basketModel->getSums());
        $billing = View::factory('pokladna/addressReadOnly')->set($this->session->get('pokladna.billing'))->render();
        $shaddr = $this->session->get('pokladna.shipping');
        $shipping = ($shaddr && $this->session->get('pokladna.address_selector')>=0)  ? View::factory('pokladna/addressReadOnly')->set($shaddr) : Kohana::lang('pokladna.same-as-billing');
        $this->content->content =  View::factory('pokladna/rekapitulace')
                ->set('basket',$basket->render())
                        ->set('billing_address',$billing)
                        ->set('shipping',$shipType)
                        ->set('sums',$basketModel->getSums())
                        ->set('shipping_address',$shipping);
        
    }



    public function dokonceni() {
        //todo: ulozit objednavku,
        //uloz do databaze
        //odesli email
        //presmeruj na podekovani
        
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

        $uinfomodel = new User_info_Model();
        
        $shipping_valid = $uinfomodel->validate($shipping);
        $billing_valid = $uinfomodel->validate($billing);               
        

        $pokladna = $this->session->get('pokladna',array());
        
        if($shipping) $pokladna['shipping'] = $shipping; //else unset($pokladna['shipping']);
        $pokladna['address_selector'] = $fields['address_selector'];
        $pokladna['billing'] = $billing;
        $this->session->set('pokladna',$pokladna);

        $email = $billing['email'];

        if(valid::email($email) && $billing_valid && (count($shipping)==0  || $shipping_valid ) ) {
            url::redirect('pokladna/rekapitulace');
        } else {
            error::add(Kohana::lang('pokladna.address-not-valid'));
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