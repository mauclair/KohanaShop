<?php

/**
 * @property Table_Model $table
 */
class Overview_Model extends Model {

    private $table;

    public function __construct() {
        parent::__construct();
        $this->fields = "
                 cdate,
                 FROM_UNIXTIME(cdate, '%Y%j') as day,
                 FROM_UNIXTIME(cdate, '%Y%m') as month,
                 FROM_UNIXTIME(cdate, '%Y%u') as week,
                 COUNT(order_id) as number_of_orders,
                 SUM(order_subtotal) as revenue,
  		 SUM(IF(order_status='V',order_subtotal,0)) as revenue_V,
  		 SUM(IF(order_status='P',order_subtotal,0)) as revenue_P,
  		 SUM(IF(order_status='C',order_subtotal,0)) as revenue_C,
  		 SUM(IF(order_status='X',order_subtotal,0)) as revenue_X,
  		 SUM(IF(order_status='S',order_subtotal,0)) as revenue_S,
                 SUM(IF(order_status='S',order_shipping,0)) as shipped_shipping
                ";
        $this->table = new Table_Model('orders', 'order_id');
        $this->table->select($this->fields);
        //$this->table->join('order_items', 'order_id');
    }

    public function byMonths($from=null, $to=null, $order = null) {
        if (!$order)
            $order = 'cdate DESC';
        $this->table->orderBy($order);
        if ($from) {
            $this->table->where('cdate', $from, '>=');
        }
        if ($to) {
            $this->table->where('cdate', $to, '<=');
        }
        $this->table->groupBy = 'month';
        return $this->table->fetch();
    }

    /**
     * Return chart from overview data
     * @param <type> $data
     * @param string $x - field for X labels
     * @param array $y syntax 'field'=>options where options are [color,transparent,key]
     */
    public function chart($data, $x, $y, $hooks = null) {
        include_once Kohana::find_file('vendor', 'php-ofc-library/open-flash-chart');
        $g = new open_flash_chart();
        $areas = array();
        $values = array();
        $labels = array();
        if (!is_array($y))
            $y = array($y => array());

        // data part
        foreach ($y as $field => $value) {
            $areas[$field] = new bar();
            $values[$field] = array();
            if (!isset($value['color'])) $value['color'] = '#666';
            $areas[$field]->colour($value['color']);
            if(isset($value['transparent'])) $areas[$field]->set_alpha ($value['tramsparent']);
            if(isset($value['key'])) $areas[$field]->set_key($value['key'],10);                           
        }
        //prepare data
        $y_max = 0;
        foreach ($data as $r) {
            $r = (array) $r;
            foreach ($y as $field => $v) {
                if (isset($r[$field])){
                    $value = (float)$r[$field];
                    if(isset($hooks[$field])) $value = call_user_func ($hoohs[$field],$value);
                    if($y_max < $r[$field]) $y_max = $value;
                    $values[$field][] = $value;
                }
            }
            $value = $r[$x];
            if(isset($hooks[$x])) $value = call_user_func($hooks[$x], $value);

            $labels[] = $value;
        }
        
        // setting the data
        foreach ($y as $field => $v) {
            $areas[$field]->set_values($values[$field]);
            $g->add_element($areas[$field]);
        }

        // visual part
        //X axis
        $x = new x_axis();
        $x->set_grid_colour('#ffffff');
        $xl = new x_axis_labels();
        $xl->set_vertical();

        $xl->set_labels($labels);        
        $x->set_labels($xl);
        $x->stroke(1);      

        // Y axis
        $y = new y_axis();
        $yl = new y_axis_labels();

        $y->set_stroke(1)->set_range(0, $y_max * 1.1)->set_steps($y_max / 10);
        $y->set_grid_colour('#e0e0e0');

        $yleg = new y_legend();
        $yleg->y_legend('Kč');
        $yleg->set_style('{}');
        
        //$yl->set_size(0);
       // $yl->set_text('');
        $y->set_labels($yl);  

        $g->set_y_legend($yleg);        
        $g->set_y_axis($y);
        $g->set_x_axis($x);
        $g->set_bg_colour('#ffffff');


        return $g->toString();
    }

    public function formatMonth($month){
        return Kohana::lang('main.months.'.((int)substr($month , 4)-1)).' '.substr($month,0, 4);
    }

}

?>
