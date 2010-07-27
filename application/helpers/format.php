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

    public static function prize($number,$format = array()){
        $default_format = array('decimals'=>2,'round-to'=>1 ,'prepend'=>'','append'=>'','pad-to'=>0,'padding-str'=>'&nbsp;');
        $fmt = $format + $default_format;
        $number = round($number,$fmt['round-to']);
        $number = number_format($number, $fmt['decimals']);
        if($fmt['pad-to'] > strlen($number)) {
            for($i=strlen($number);$i<$fmt['pad-to'];$i++) $number = $fmt['padding-str'].$number;
        }
        if($fmt['prepend']) $number=$fmt['prepend'].$fmt['padding-str'].$number;
        if($fmt['append']) $number.=$fmt['padding-str'].$fmt['append'];
        return $number;
    }

    //put your code here
}
?>
