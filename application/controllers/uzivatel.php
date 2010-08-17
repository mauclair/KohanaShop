<?php
class Uzivatel_Controller extends Shop_Controller {
    public static $clean_user =  array(
            'email'=>'@',
            'username'=>'',
            'company'=>'',
            'ico'=>'',
            'dico'=>'',
            'chceVelkoobchod' => 'N',
            'city' => '',
            'zip' => '',
            'name' =>'',
            'phone_1' => '',
            'address_1'=>'',
            'user_advertisement'=>'Y',

    );

    public function registrovat() {

        $data =  $this->input->post(null,  self::$clean_user);
        $this->template->content = View::factory('user/login')->set($data)
                ->set('register',View::factory('user/register_form')->set($data));
    }

    public function novy() {
        $u = new User_Model();
        $_POST['password'] = md5($_POST['password']);
        $_POST['password_again'] = md5($_POST['password_again']);
        $_POST['npwd'] = md5(Kohana::config('main.pwd-salt').$_POST['username'].$_POST['password']);
        $this->session->set('passedRegister',$_POST);
        if($u->add($_POST)) {
            url::redirect('register/success');
        } else {
            $this->index();
        }

    }

    public function success() {
        $this->template->content = View::factory('user/registerSuccess')->render();
    }

    public function lostPassword() {
        $this->template->content = View::factory('user/lostPassword')->render();
    }

    public function lostPasswordSend() {
        if(valid::email($_POST['email'])) {

            $u = $this->model->get($_POST['email'],'email');
            if($u) {
                $u['password']=''; // don't update user pass
                $u['LPToken'] = md5(uniqid());
                $u['new_password'] = text::random();
                $mail = View::factory('mail/'.$this->session->get('lang','de').'/lostPassword')->set($u);
                $u['new_password'] = md5($u['new_password']);

                if($this->model->update($u,false)) $this->template->content = $mail;
                $this->template->content = View::factory('user/lostPasswordSent');
                return;
            }
        }
        error::add(Kohana::lang('user.provide-valid-email'));
        url::redirect('register/lostPassword');

    }

    public function confirmLostPassword($token) {
        if(!valid::alpha_numeric($token)) {
            error::add('user.not-valid-token');
        }
        else {
            $u = $this->model->get($token,'LPToken');
            if(!$u) error::add('user.not-valid-token');
            else {
                $u['password'] = $u['new_password'];
                $u['password_again'] = $u['new_password']; // to satisfy validator
                $u['LPToken'] = '';
                $u['new_password'] = '';
                $this->model->update($u,false);
                error::add(Kohana::lang('user.password-changed'),'message');
                url::redirect('user/login');

            }
        }
    }

    public function prihlasit() {
        $this->template->content = View::factory('user/login_form');
    }

    public function registrovat_se() {
        $this->template->content = View::factory('user/register_form')->set(self::$clean_user);
    }

    public function login() {
        $u = new User_Model();
        if(!$u->login($this->input->post('username'),md5($this->input->post('password')))) {
            error::add('user.login-failed');
            url::redirect($this->session->get('current-page','uzivatel/loginFailed'));
        } else url::redirect($this->session->get('go-after-login',$this->session->get('last-page','/')));
    }

    public function saveAddress() {
        $ui = new User_info_Model();
        $a = $this->input->post();
        if(isset($a['new_address'])) {// chceme ulozit novou adresu
            $ui->add($a);
        } else {
            $ui->update($a);
        }
        if(!request::is_ajax()) url::redirect($this->Session->get('current-page',$this->Session->get('current-page')));
    }

    public function addressForm() {
        $id = (int)$this->input->post('user_info_id',-1);
        if($id<0) {
            $this->template->content = '';
            return;
        }
        $data = self::$clean_user;
        if($id>0 ) { // load
            $uim = new User_info_Model();
            $data = $uim->get($id);
        }
        $this->template->content = View::factory('pokladna/address_form')->set($data);
    }

    public function logout(){        
        $this->session->delete('user');
        url::redirect('/');
    }

    public function muj_ucet(){
        $this->template->content ='TODO> MUJ UCET';
    }

    public function objednavka($order_number){
        $order_number = (int)$order_number;
        $order_model = new Order_Model();
        $order = $order_model->getOrder($order_number);
        $this->template->content = View::factory('order/readonly')->set($order);
    }
}
?>
