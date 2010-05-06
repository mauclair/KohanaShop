<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author snoblucha
 */
class User_Model extends Table_Model {
    public $table = 'user';
    public $id =  'user_id';

    public $validation = array('name'=>'required','password'=>array('required','matches[password_again]'),'email'=>array('required','valid::email'));

    public function __construct() {
        parent::__construct('user');
        $this->join('user_info', 'user_id');
        $this->join('shopper_group', 'shopper_group_id');
        $this->where('address_type','BT');

    }

    public function login($email,$password) {
        //if(!valid::email($email)) return false; // have valid data
        
        $npwd = self::hash($password, $email);        
        //$u = $this->get(array('email'=>$email, 'password'=>$password));
        $u = $this->get($npwd,'npwd');
        if($u) {
            Session::instance()->set('user',$u);
            Logger_Model::login();
            return true;
        }
        else return false;
    }

    public function add(&$d) {
        if($this->validate($d)) {
            $this->validation = array();
            return parent::add($d);
        } else return false;
    }


    public function update(&$d,$hashPwd = true) {
        if(empty($d['password'])) {
            unset($this->validation['password']);
            unset($d['password']);
        }
        else if($hashPwd){
            $d['password'] = md5($d['password']);
            $d['password_again'] = md5($d['password_again']);
            $d['npwd'] = self::hash($d['password'], $d['email']);
            
        }        
        if($this->validate($d)) {

            $this->validation = array();
            return parent::update($d);
        } else {            
            return  false;
        }
    }

    public function logged() {
        $s = Session::instance();
        if($s->get('user')) return true;
        else return false;
    }

    public static function isLogged() {
        $s = Session::instance();
        if($s->get('user')) return true;
        else return false;
    }

    public static function getLogged() {
        return Session::instance()->get('user');
    }

    public static function hash($pwd,$email){
        return md5(Kohana::config('main.pwd-salt').$email.$pwd);
    }

   public static  function isAdmin() {
        $u = Session::instance()->get('user');
        if(!$u) return false;
        if($u['level']==0) return true;
        else return false;
    }





}
?>
