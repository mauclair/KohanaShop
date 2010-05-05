<?php

class sharedState_Core {
    private $model;
    private static $instance = null;
    public function __construct() {
        $this->model = new Table_Model('sharedstate');
        $this->model->schema = array( 'map_key'=>'varchar(255)','expires'=>'INT','value'=>'text');
        $this->model->checkTable();
        //   $this->model->createTable($this->model->schema);
    }


    /**
     * Sets the shared state with given key to given value. The expire seconds can be set
     * @param string $key
     * @param mixed $value
     * @param int $expires  - seconds to expire the value
     * @param string $prolong - if we need to prolong some key as well
     */
    public static function set($key,$value,$expires=30,$prolong=false) {
        self::checkInstance();

        $old_value = self::get($key);
        $a = array('map_key'=>$key, 'value'=>json_encode($value),'expires'=>time() + $expires );
        if(!$old_value) {
            self::$instance->model->add($a);
        }
        else  self::$instance->model->update($a,'map_key');
        if($prolong) self::prolong($prolong);
    }
/**
 * Prolongs the expiration of the key ... 
 * @param string $key
 * @param int $expires
 */
    public static function prolong($key,$expires=30){
        self::checkInstance();
        self::$instance->model->query("UPDATE sharedstate SET  expires= ".time()+$expires."");
    }

    /**
     *  Looks for key in database and returns its value. If preffered value is set
     *  and key is not found in database, preffered value is returned instead of false.
     *
     * @param string $key - ket ro look for
     * @param  mixed/optional $prefferred_value  - what to return if key does not exits (false by default)
     * @return mixed
     */
    public static function get($key,$prefferred_value=false) {
        self::checkInstance();
        self::check();
        $res = self::$instance->model->get($key,'map_key');
        if(!$res && $prefferred_value ) {
            return $prefferred_value;
        }
        else if(!$res) return false;
        else  return json_decode($res['value'],true);
    }

    /**
     *  Deletes all expired values
     * @return true
     */
    public static function check() {
        self::checkInstance();        
        self::$instance->model->query("DELETE FROM sharedstate WHERE expires < '".time()."'");
        return true;
    }

    /**
     *  Returns instance of sharedState_Core object.
     * @return sharedState_Core
     */
    public static function instance() {
        self::checkInstance();
        return self::$instance;
    }

    /**
     * Checks if instance exists, if not, then sets it up. This follows singleton model.
     */
    private static function checkInstance() {
        if(!self::$instance) self::$instance = new sharedState_Core();
    }

    /**
     *  Deletes key form database
     * @param string $key
     */
    private static function delete($key){
        self::checkInstance();
        self::$instance->model->delete($key,'map_key');
    }



}

?>
