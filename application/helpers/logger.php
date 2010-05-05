<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logger
 *
 * @author snoblucha
 */
class Logger_Core {
    private static  $fo;
    public static function add($line){
        if(!self::$fo) self::initialize();
        fwrite(self::$fo,$line."\n");
    }

    public static function clear(){        
        if(self::$fo){
            fclose(self::$fo);
            unlink('log.log');
        }
    }

    public static function getString(){
        if(self::$fo)  fflush(self::$fo);
        if(file_exists('log.log')){return  file_get_contents('log.log'); } else return '';


    }

    public static function initialize(){
        if(self::$fo) fclose(self::$fo);
        self::$fo = fopen('log.log','w');
    }

}
?>
