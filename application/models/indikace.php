<?php
class Indikace_Model extends Table_Model {
    public $table = 'indikace';
    public $id = 'indikace_id';
    public $autoUrl = array('indikace_name'=>'indikace_url');



    public function getProducts($indikace_id, $offset=0,$limit=false){
        $p = new Product_Model();
        $p->where->in('product_id',"SELECT product_id FROM indikace_xref WHERE indikace_id = '$indikace_id'");
        if($limit) $p->limit($offset, $limit);
        return $p->fetch();
    }


    /**
     * Update indikace_joined table
     * @param integer $indikace_id 
     * @param integer $product_id 
     */
    public function updateIrefsTable($indikace_id = false, $product_id = false) {        
        $where = '';
        if($indikace_id) {
            $where = " product_id IN (SELECT indikace_id FROM product_indikace_xref WHERE indikace_id = '$indikace_id') ";
        }
        if($product_id) {
            $where .= ($indikace_id) ? ' OR' : ''; // is indikace -> add OR
            $where .= " product_id = '$product_id' ";
        }
        $where = ($where) ? "WHERE $where": '';
        $q = "DELETE FROM indikace_joined $where";
        $this->query($q);
        $base = url::base();
        $q  = "INSERT INTO indikace_joined (product_id,i_refs)
                SELECT product_id,
                GROUP_CONCAT( DISTINCT CONCAT( '<a href=\"{$base}indikace/', indikace_url, '.html\">', indikace_name, '</a>' )
                    ORDER BY indikace_name
                    SEPARATOR ', ' ) AS i_refs
                FROM indikace_xref
                JOIN indikace
                USING ( indikace_id )
                $where
                GROUP BY product_id";
        $this->query($q);
    }

    public function updateUrls(){
        $m = Table_Model::factory($this->table,$this->id);
        $data = $m->fetch();
        set_time_limit(0);
        foreach($data as $p){
            $t = (array)$p;
            $t['indikace_url'] = url::title($t['indikace_name']);
            $m->update($t);
            unset($t);
        }
    }
     
}
?>
