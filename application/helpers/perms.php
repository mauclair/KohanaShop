<?php
class Perms_Core {
    public static $perms = null;

     public static function allowed($address=null,$user=null) {
        if(!self::$perms) self::$perms = Kohana::config('perms');
        if(!$user)  $user = Session::instance()->get('user');
        if(!$user) $user = array('level'=>10000000);
        $uri = URI::instance();
        $c = $uri->segment(1);
        $m = $uri->segment(2);

        if($address) { // use passed in address   {model/controller}
            list($c,$m) = explode('/',$address);
        }
        if(!isset(self::$perms[$c])) return true; // no perms for controller required ... allow

        $cperms = self::$perms[$c];

        $res = (!isset($cperms['level']))? true :  $user['level'] <= $cperms['level'];
        //// check the level for controller and set it as initila value, if the level is not set, then allow anyone
        $res = self::parseExtendedPermissons($cperms, $user, $res); //parse perms for controller

        if(isset($cperms[$m])){ // rules are set for method override perms for controller
            $mperms = $cperms[$m]; // temp perms for method
            $res = (!isset($mperms['level'])) ? true : $user['level'] <= $mperms['level']; // set initial required level for method
            $res = self::parseExtendedPermissons($mperms, $user, $res); // parse perms for method
        }
        return $res;
    }

    protected static function parseExtendedPermissons(&$perms,&$user,$starting_permission) {

        if(!isset($perms['allow']) && !isset($perms['deny'])) return $starting_permission; // extended perms are not set, no change
        $res = $starting_permission;

        foreach($perms as $k=>$v){

            if($k == 'allow') $res = self::getExtendedPermissions($v, $user,true,$res);
            if($k == 'deny') $res = self::getExtendedPermissions($v, $user,false,$res);
        }
        return $res;
    }

    protected static function getExtendedPermissions(&$perms,&$user,$value,$initial_value){
        $res = $initial_value;
        foreach($perms as $k=>$v){
               if(!is_array($v)) $v = array($v);
               foreach($v as $val) { // for every allowed value
                   if(isset($user[$k]) && $user[$k]== $val) $res = $value;
               }
            }
        return $res;
    }
    
}

?>
