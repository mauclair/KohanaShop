<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of format
 *
 * @author snoblucha
 */
class Format_Core {
    public static function size($size){
              $units  = array('B','kB','MB','GB','TB');
              $pow = floor(log($size,1024));
              if($pow<0) $pow = 0;
              return round($size / pow(1024,$pow),1).' '.$units[$pow];
    }

    public static function currency(){

    }

    //put your code here
}
?>
