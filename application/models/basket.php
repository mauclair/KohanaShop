<?php
class Basket_Model extends Model {
    public  $items = array();
    public  $session;
    public function __construct() {
        $this->session = Session::instance();
        if (!isset($_SESSION['basket-data'])) $_SESSION['basket-data'] = array();
        parent::__construct();
    }



    public function addItem($lid,$count=1) {
        if ($count <=0) return;
        $expiration = time() + Kohana::config('main.basket-item-expiration')*60;
        if (isset($_SESSION['basket-data'][$lid])) {
            $_SESSION['basket-data'][$lid]['count'] += $count;
            $_SESSION['basket-data'][$lid]['expires'] = $expiration;
        } else {
            $p = new Product_Model();
            $_SESSION['basket-data'][$lid]['count'] = $count;
            $_SESSION['basket-data'][$lid]['expires'] = $expiration;
            $pdata = $p->get($lid);
            $_SESSION['basket-data'][$lid]['data'] = $pdata;
            $_SESSION['basket-data'][$lid]['data']['prize'] = $pdata['product_price']*(1.0 + $pdata['product_taxes_value']*0.01)* (1.0  -  $pdata['product_discount_id']*0.01);

        }
        return true;
    }


    public function deleteItem($lid,$count = 1) {
        if (isset($_SESSION['basket-data'][$lid])) {
            if ($_SESSION['basket-data'][$lid]['count'] < $count) $count = $_SESSION['basket-data'][$lid]['count'];
            $_SESSION['basket-data'][$lid]['count']-= $count;
            if ($_SESSION['basket-data'][$lid]['count']<=0) unset($_SESSION['basket-data'][$lid]);

            return true;
        } else { // neni v kosiku
            error::add(Kohana::lang('basket.not-in-basket'));
            return false;
        }

    }

    public function deleteItems($lids) {
        if (!is_array($lids)) {
            $lids = array($lids);
        };
        foreach ($lids as $lid) {
            $this->deleteItem($lid);
        }
    }

    public function add(&$d) {
        $valid = new Validation($d);
        $valid->add_rules('quantity','required','valid::numeric');
        $valid->add_rules('product_id','required','valid::numeric');
        if ($valid->validate()) {
            $this->addItem($d['product_id'],$d['quantity']);
            return true;
        } else {
            error::add('ERRRORR');
            return false;
        }
    }

    public function deleteAll() {
        //todo: tady se bude muset aktualizovat databaze, listky co jsou v kosikach se zaktivni
        $_SESSION['basket-data'] = array();

    }

    public function get() {
        $in = array_keys($_SESSION['basket-data']);
        if (!$in) return array();
        return $_SESSION['basket-data'];

    }

    public function hasItems() {
        return (count($_SESSION['basket-data'])>0);
    }

    /**
     * IS there a Ticket with ID in Basket?
     *
     * @param int $vid
     */

    public function isIn($vid) {
        return isset($_SESSION['basket-data'][$vid]);
    }

    /**
     * *REMOVES ALL TICKETS WITH GIVEN ID FROM BASKET
     *
     * @param int $vid
     */

    public function remove( $vid) {
        if ($this->isIn($vid))	$this->deleteItem($vid,$_SESSION['basket-data'][$vid]['count']);
    }

    public function modify(&$a) {
        $data = new Validation($a);
        $data->add_rules('product_id','required','numeric');
        $data->add_rules('quantity','required','numeric');
        if (!$data->validate()) {
            error::parseValidation($data->errors());
            return false;
        }
        $data = $data->as_array();
        $vid = $data['product_id'];
        $pocet = $data['quantity'];
        if (!$this->isIn($vid)) return false; // to kdyby tam nahodou nebyla
        $item = $_SESSION['basket-data'][$vid];

        if ($pocet <= 0 ) { // odebira se na nulu, nebo tak
            $this->remove($vid);
        }else if ($pocet>$item['count'] ) { // zkusime pridat, pokud chce vic
            $this->addItem($vid,$pocet - $item['count']);
        } else if($pocet < $item['count']) { // zkusime odebrat pokud chce min
            $this->deleteItem($vid,$item['count'] - $pocet );
        }
        return true;

    }

    public function getSums() {
        //$_SESSION['basket-data'] = array();
        $sum = 0;
        $count = 0;
        foreach ($_SESSION['basket-data'] as $k=>$v) {
            $count += $v['count'];
            $sum += $v['data']['prize'] * $v['count'];
        }
        return array('sum'=>$sum, 'count'=>$count);
    }

    public static function sums() {
        $b = new Basket_Model();
        return $b->getSums();
    }

    public static function getCount() {
        $b = new Basket_Model();
        $sums = $b->getSums();
        return $sums['count'];

    }

}

?>