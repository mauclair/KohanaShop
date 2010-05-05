<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banner
 *
 * @author snoblucha
 */
class Banner_Model extends Table_Model {
    public $table = 'banners';
    public $id ='banner_id';
    public $fields = array('*',"DATE_FORMAT(display_from,'%e.%c.%Y') as dfrom","DATE_FORMAT(display_to,'%e.%c.%Y') as dto");
    public $files = array( 'banner_file'=>array(
                                'directory'=>'banners',
                                'validate'=>array('upload::required','upload::type[jpg,png,gif,swf,jpeg]'))
                         );
  //  public $validation = array('banner_file'=>'required');

    public static function render($banner_id){
        $banner = array();
        if(is_object($banner_id) || is_array($banner_id) ){
            $banner = (array)$banner_id;
        } else {
            $b = new Banner_Model();
            $banner = $b->get($banner_id);
        }

        if(!$banner)return '';
        $banner['banner_width'] = 100;
        $banner['banner_height'] = 100;       
        return View::factory('admin/banner/preview_item')->set($banner)->render();

    }

    public function getBanners(){
        $res = array();
        $bcm = new BannerCategory_Model();
        $bcdata = $bcm->fetch();
        foreach($bcdata as $cat) {
            $hid =  $cat->bannerCategory_html_id;
            $slots =  $cat->bannerCategory_slots;
            $res[$hid] = array();
            $bm = new Banner_Model();
            $bm->where->where('banner_group', $hid);
            $bm->where->where("(display_from <= '".date('Y-m-d')."' OR display_from = '0000-00-00')", '', ' ',true);
            $bm->where->where("(display_to >= '".date('Y-m-d')."' OR display_to = '0000-00-00')", '', ' ',true);
            $bm->where->where("(display_clicks = '0' OR display_clicks >= clicked )", '', ' ',true);
            

            $bdata = $bm->fetch();
            $res[$hid] = $bdata->result_array(false);

            $count = count($res[$hid]);
            // now the filtering ....
            if($slots == 0 ||  $count <= $slots  ) continue; // unlimited slots or enough slots... continue
            else { // have no unlimited slots

                while($count > $slots) { // while having more items than slots unset random elements.
                    $index = rand(0, $count-1);
                    unset($res[$hid][$index]);
                    $count = count($res[$hid]);
                }
            }
        }
        
        return $res;
    }

    public function handleClick($banner_id){
        $q = "UPDATE {$this->table} SET clicked=clicked+1 WHERE banner_id = '$banner_id'" ;
        $this->db->query($q);
    }

    public function add(&$d){
       if(isset($d['file_id'])){
           Cache::instance()->delete($d['file_id']);
       }
       $res  = parent::add($d);       
       return $res;
    }
}
?>
