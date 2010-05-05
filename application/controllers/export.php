<?php
class Export_Controller extends Controller {
    private $points;
    
    public function __construct() {
        parent::__construct();
        $this->points = new Vymol_Model();
        $this->points->select(array('*',"DATE_FORMAT(created,'%Y-%m-%dT%H:%i:%s') as time","DATE_FORMAT(created, '%d.%m.%Y') AS nice_cdate"));
        
    }

    public function index(){
        $p =  $this->input->post();
        if(!$p || !isset($p['type']))  url::redirect($this->session->get('current-page'));
        switch($p['type']){
            case 'gpx' :
                $this->gpx();
                break;
            case 'ov2':
                $this->ov2();
                break;
            case 'csv':
                $this->csv();
                break;
            default:
                url::redirect('current-page');
        }
    }

    public function gpx(){
        $bounds = $this->points->getBounds();
                
        $data = array(
            'creator'=> '',
            'minlat' => 0,
            'maxlat' => 0,
            'minlon' => 0,
            'maxlon' => 0,
            'waypoints' => '',
        );
        $data = array_merge($data, $bounds);

        $data['waypoints'] = View::factory('export/gpx_items')->set('points',$this->points->fetch())->render();

        $res = View::factory('export/gpx')->set($data)->render();
        $this->auto_render = false;
        $fname  = url::title(Kohana::lang('vymoly.title').date('_Y-m-d')).'.gpx';
        return download::force($fname, $res);
    }

    public function ov2(){
        $res  = View::factory('export/ov2')->set('points',$this->points->limit(0, 1)->fetch())->render();
        $fname = url::title(Kohana::lang('vymoly.title').date('_Y-m-d')).'.ov2';
        $this->auto_render = false;        
        return download::force($fname, $res,$fname);

    }

    public function csv(){
        $res  = View::factory('export/csv')->set('points',$this->points->limit(0, 1)->fetch())->render();
        $fname = url::title(Kohana::lang('vymoly.title').date('_Y-m-d')).'.csv';
        $this->auto_render = false;
        return download::force($fname, $res,$fname);
    }

    
}
?>
