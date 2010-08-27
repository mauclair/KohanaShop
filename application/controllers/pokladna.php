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
        $this->content->content = View::factory('pokladna/kosik')->set('basket', View::factory('basket/index')->set('data',$b->get())->set('sums',$b->sums())->render());
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
            $c->set('shipping_address_id',$this->session->get('shipping_address_id',-1));
            $c->set('shipping_address',$this->session->get('shipping_address', ''));
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
        $billing = View::factory('user_info/read_only_html')->set($this->session->get('pokladna.billing'))->render();
        $shaddr = $this->session->get('pokladna.shipping');
        $shipping = ($shaddr && $this->session->get('pokladna.address_selector')>=0)
                        ? View::factory('user_info/read_only_html')->set($shaddr) : Kohana::lang('pokladna.same-as-billing');
        $save_addres_options = '';
        if( $this->session->get('pokladna.address_selector')>=0 && isset($shaddr['user_info_id']) && $shaddr['user_info_id']) {
            $uinfo_model = new User_info_Model();
            $oldAddr = $uinfo_model->get($shaddr['user_info_id']);
            $same = true;
            $score = 0;
            foreach($shaddr as $k=>$v){
                if($shaddr[$k] != $oldAddr[$k]) {$score ++; $same = false; }
            }
            $modifying_billing_address = ($this->session->get('pokladna.billing.user_info_id') == $this->session->get('pokladna.shipping.user_info_id'));
            if(!$same)
                $save_addres_options = View::factory ('pokladna/save_changed_address')->set('new_address',(2*$score>count($shaddr)))->set('modifiing_billing_address',$modifying_billing_address );
        }

        $this->content->content =  View::factory('pokladna/rekapitulace')
                ->set('basket',$basket->render())
                        ->set('billing_address',$billing)
                        ->set('shipping',$shipType)
                        ->set('sums',$basketModel->getSums())
                        ->set('shipping_address',$shipping)
                        ->set('shipping_save_address_options',$save_addres_options);
        
    }



    public function dokonceni() {
        //todo: ulozit objednavku,
        //uloz do databaze
        //odesli email
        //presmeruj na podekovani

        $order_model = new Order_Model();

        $user_id = $this->checkoutUserHandling();
        if(!$user_id) { // error
            Throw new Kohana_Exception('USER COULD NOT BE CREATED. FAILING. Contact administrator. snoblucha@email.cz');
        }
        $addresses_ids = $this->checkoutAddressesHandling($user_id);
        $note = $this->input->post('poznamka');


        $shipping_id = $this->session->get('pokladna.doprava.shipping_id');        
        $note =  $this->input->post('poznamka');
        $items = $this->session->get('basket-data');
        $order_number = $order_model->save($addresses_ids['billing_address_id'], $addresses_ids['shipping_address_id'], $shipping_id, $note, $items);

        /**
         SEND EMAIL
         */

         $order = $order_model->getOrder($order_number);


        //CLEAR DATA
        
        $this->session->delete('basket-data');
        $this->session->delete('pokladna');       

        $this->content->progress->pos = 5;
        $this->content->content = '';

        url::redirect('uzivatel/objednavka/'.$order_number);
        
    }
    /**
     * Get the user for order and return user_id. If user is not logged in, temporary user is created.
     * @return integer user_id
     */
    private function checkoutUserHandling(){
        if(User_Model::isLogged()){// user is logged, just retur his/her ID
            $user = User_Model::getLogged();
            return $user['user_id'];
        } else { // not Logged ... register new one and send email for registration
            $user_Model = new User_Model();            
            $user = Uzivatel_Controller::$clean_user;

            $user['username'] = $user['email'] = $this->session->get('pokladna.billing.email');
            $user['plain_password'] = Text::random( 'alnum', 5);
            $user['password_again'] = $user['password'] = $user['plain_password'];
            if(($user['user_id'] = $user_Model::add($user))) {
                return $user['user_id'];
            } else {
                return false;
            }
        }
    }

    private function checkoutAddressesHandling($user_id){
        $user_info_model = new User_info_Model;
        $billing_address_id = $this->session->get('pokladna.billing.user_info_id');
        if(!$billing_address_id ){ // neni v databazi, pridat
            $billing_address = $this->session->get('pokladna.billing');
            $billing_address['user_id'] = $user_id;
            $billing_address_id = $user_info_model->add();
        }
        $shipping_address_id = $this->session->get('pokladna.address_selector');
        $shipping_address = $this->session->get('pokladna.shipping');
        $shipping_address['user_id'] = $user_id;
        
        if($shipping_address_id && $shipping_address_id>0) { // selected existing address - check if match, if not updat/save passed thru the selection
            $save_address = $this->input->post('save_address');
            if($save_address == 'new' || ($shipping_address_id == $billing_address_id && $save_address == 'update' )) { // want to save as a new address,
                //or modifying billing address  - WE DO NOT ALLOW IT ... unpredicted behaiviour
                unset($shipping_address['user_info_id']);
                $shipping_address_id = $user_info_model->add($shipping_address);
            } else if($save_address == 'update') { //
                  $user_info_model->update($shipping_address);
            } else { //no changes to address
                
            }
        } else if($shipping_address_id == -1){ // same as billing
            $shipping_address_id = $billing_address_id;
        } else {                        
            $shipping_address_id = $user_info_model->add($shipping_address);
        }
        return array('shipping_address_id'=>$shipping_address_id, 'billing_address_id'=>$billing_address_id);
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