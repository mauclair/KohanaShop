<?php
    class Ucet_Controller extends Shop_Controller {
        public $model;
        public $user_id;
        
        public function __construct() {
            parent::__construct();
            $this->user_id = $this->session->get('user.user_id');
        }

        public function index(){
            $this->template->content = View::factory('ucet/prehled')
                    ->set($this->session->get('user'))
                    ->set('objednavky',$this->_objednavky())
                    ->set('adresy',$this->_adresy())
                            ;
        }

        public function objednavky(){

        }

        public function uprava_adresy($address_id){
            $am = new User_info_Model();
            $am->where('user_id',$this->user_id)->where('user_info_id', $address_id);
            $addr = $am->fetch();
            if($addr->count()<=0) {
                url::redirect('ucet');
                return;
            }
            $adresa = (array)$addr->current();
            $this->template->content = View::factory('ucet/adresa')->set($adresa)->set('action','ucet/saveAddress')->render();
        }

        public function saveAddress(){
            $a = $this->input->post();
            $am = new User_info_Model();
            $am->where('user_id',$this->user_id)->where('user_info_id', $a['user_info_id']);
            $addr = $am->fetch();
            if($addr->count() > 0 ) {
                $am->update($a);
                
            }
            if(!request::is_ajax())url::redirect('ucet');
        }

        public function _adresy(){
            $adresyM = new User_info_Model();
            $adresyM->where('user_id', $this->user_id);
            $adresy = $adresyM->fetch();
            return View::factory('ucet/adresy')->set('adresy',$adresy)->render();
        }

        
        public function _objednavky(){
            $om = new Order_Model();
            $om->where('user_id', $this->user_id);
            $om->orderBy('cdate DESC');
            return View::factory('ucet/objednavky')->set('objednavky',$om->fetch())->render();
        }



    }
?>