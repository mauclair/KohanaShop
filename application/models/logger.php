<?php

class Logger_Model extends Model {
    public static function search($keyword){
        $u  = User_Model::getLogged();
        if($u) {
            $u['keyword'] = $keyword;
            $u['search_date'] =  date('Y-m-d H:i:s');
            Table_Model::factory('log_search')->add($u);
        }
    }

    public static function login(){
        $u  = User_Model::getLogged();
        if($u) {            
            $u['login_date'] =  date('Y-m-d H:i:s');
            $u['ip'] = $_SERVER['REMOTE_ADDR'];
            $loc = Session::instance()->get('ipLoc');
            if($loc) {

                $loc = (array) $loc;
                $u['location'] = $loc['Latitude'].' '.$loc['Longitude'];
            }
            Table_Model::factory('log_login')->add($u);
        }        
    }

    public static function viewVymol($vymol_id){
        $u  = User_Model::getLogged();
        if($u) {
            $u['view_date'] =  date('Y-m-d H:i:s');
            $u['vymol_id'] = $vymol_id;
            Table_Model::factory('log_vymol')->add($u);
        }
    }


}
?>
