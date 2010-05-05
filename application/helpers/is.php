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
        return (isset($_SESSION['user']) && $_SESSION['user']);
    }

    public static function admin(){
        
    }

    public static function current($url,$return_class_string = true, $anotherMatches=array()){
        $res = ($return_class_string) ? ' class="current" ' : true;
        $m = uri::instance()->segment_array();       
       
        $am_res = false;
        if($anotherMatches) {
            foreach($anotherMatches as $v){
                $v = explode('/',$v);
                $tres = true;
                foreach($v as $k=>$val){
                    if($val=='*') break; // wildcard, anything behind this matches -- end cycle success
                    if(!isset($m[$k+1]) || strcmp($val,$m[$k+1])!=0) {$tres = false; break; } // not matched, end iimediatly failed
                }
                $am_res = $tres;
                if($am_res) break; // first match is enough
            }
        } // replace wildcard to method
        if(url::current() == $url || $am_res) {
            return $res;
        } else return false;
        
    }

    public static function href($url,$anotherMatches = array()){
        $res = ' href="'.url::site($url).'"'.self::current($url,true,$anotherMatches);
        return $res;
    }

}
?>
