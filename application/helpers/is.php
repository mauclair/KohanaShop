<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of is
 *
 * @author snoblucha
 */
class is_Core {
    public static function logged(){
        return isset($_SESSION['user']);
    }

    public static function admin(){
        
    }

    public static function group(){
       if(!isset($_SESSION['user-group'])){            
            $_SESSION['user-group'] = kohana::config('main.default-user-group');
       }       
       return $_SESSION['user-group'];
    }

}
?>
