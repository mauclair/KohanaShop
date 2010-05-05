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
    public $table = 'auth_user_md5';
    public $id = 'user_id';
    public $validation = array('username'=>array('required','unique'), 'password'=>array());

    public function __construct() {
        parent::__construct();
        $this->joins[] = array('table'=>'shopper_vendor_xref','field'=>'user_id');
    }
    /**
     * Tries log in user, on succes Session var with key 'user' is created
     * @param string $username
     * @param string $md5password
     * @return boolean - success?
     */
    public function try_login($username,$md5password) {
        $this->addFilter('password', $md5password)->addFilter('username', $username);
        $q = $this->fetch();
        if($q->count() > 0) {
            $_SESSION['user'] = (array)$q->current();
            $_SESSION['user-group'] = $_SESSION['user']['shopper_group_id'];
            return true;
        }
        else {
            unset($_SESSION['user']);
            return false;
        }
    }
    /**
     * Logout the user
     */
    public function logout(){
        unset($_SESSION['user']);
        unset($_SESSION['user-group']);
    }
    

}
?>
