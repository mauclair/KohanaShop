<?php
class Psc_Model extends Table_Model {
    public $table = 'psc';
    public $id = 'psc';

    /**
     *
     * @param string $city_start - first letters of town
     * @param boolean $return_array Return as array
     * @return array|Database_Result
     */
    public static function getByTown($city_start, $return_array = false){
        $instance = new Psc_Model();
        $instance->where->like('posta', $city_start.'%');
        $result = $instance->fetch();
        if($return_array)$result->result_array(); else return $result;
    }
/**
     *
     * @param string $psc_start - first letters of town
     * @param boolean $return_array Return as array
     * @return array|Database_Result
     */
    public static function getByPsc($psc_start, $return_array = false){
        $instance = new Psc_Model();
        $instance->where->like('psc', $psc_start.'%');
        $result = $instance->fetch();
        if($return_array)$result->result_array(); else return $result;
    }
}

?>
