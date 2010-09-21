<?php
class My_Controller extends Crud_Controller {

    public $template = 'mainTpl';
    public $cache;
    public $session;

    public function  __construct() {
        parent::__construct();
         if(!request::is_ajax()) $this->profiler = new Profiler();
        $this->cache = Cache::instance();

        $this->template->title= Options_Model::ret('site-name');
        $this->template->content = '';
        $this->template->css = 'styles/style.php';
        $this->template->keywords = Options_Model::ret('keywords');
        $this->template->description = Options_Model::ret('description');
        $this->template->quickSearch = View::factory('layout/quickSearch');
        $this->template->directLogin = View::factory('layout/directLogin');
        $this->template->topMenu= 'top-menu';//View::factory('layout/top_menu');
        $this->template->loggedInfo = View::factory('layout/loggedInfo');
        $this->template->minicart = View::factory('layout/minicart')->set('data',array());
        $this->template->langSwitch = View::factory('layout/lang_switch');
        $this->template->currencySwitch = View::factory('layout/currency_switch');
        $this->template->leftMenuBar = View::factory('layout/leftMenuBar');
//        $this->template->footer = View::factory('footer')->render();

        $this->session = Session::instance();
        $this->_init_language();
        //$this->_find_location();

        if(!perms::allowed()) {
            if(User_Model::isLogged()) 
                url::redirect('user/no_perms');
            else  url::redirect('uzivatel/prihlasit');
        }
        //  $this->_prepare_articles();
       // $this->_prepare_banners();

    }

    public function _render() {
        if(request::is_ajax()) {
            echo $this->template->content;
            return;
            //echo $bitch;
        }
        // $this->template->content .= $this->profiler->render(true);
        $this->session->set('last-page',$this->session->get('current-page'));
        $this->session->set('current-page',url::current());


        $this->template->headerLinks = '';

        parent::_render();
    }

    public function changeLanguage($lang) {
        $this->_setLanguage($lang);
        url::redirect($this->session->get('current-page'));
    }

    private function _init_language() {
        $lang = $this->session->get('lang');
        if(!$lang) {
            $user_languages = array();
            if ( isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) ) {
                $languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
                // $languages = ' fr-ch;q=0.3, da, en-us;q=0.8, en;q=0.5, fr;q=0.3';
                $languages = str_replace( ' ', '', $languages );// need to remove spaces from strings to avoid error
                $languages = explode( ",", $languages );
                foreach ( $languages as $language_list ) {
                    // pull out the language, place languages into array of full and primary
                    // string structure:
                    $temp_array = array();
                    // slice out the part before ; on first step, the part before - on second, place into array
                    $temp_array[0] = substr( $language_list, 0, strcspn( $language_list, ';' ) );//full language
                    $temp_array[1] = substr( $language_list, 0, 2 );// cut out primary language
                    //place this array into main $user_languages language array
                    $user_languages[] = $temp_array;
                }
            }
            if(!isset($user_languages[0])) $user_languages[0][1] = 'en';
            $lang = $user_languages[0][1];
            $lang_full = 'en_US';
            $this->_setLanguage($lang);
        }
        else {
            Kohana::config_set('locale', $this->session->get('lang_full','en_US'));
        }
    }

    private function _setLanguage($lang) {
        switch($lang) {
            case 'cs':
                $lang = 'cz';
                $lang_full = 'cs_CZ';
                break;
            case 'de':
                $lang='de';
                $lang_full = 'de_DE';
                break;
            default:
                $lang='en';
                $lang_full = 'en_US';
        }

        $this->session->set('lang',$lang);
        $this->session->set('lang_full',$lang_full);
    }

    private function _prepare_articles() {
        $article_list = $this->cache->get('article_list'.$this->session->get('lang'));
        if(!$article_list) {
            $arts = new Articles_Model();
            $article_list = $arts->fetch()->result_array();
            $this->cache->set('article_list'.$this->session->get('lang'),$article_list,array('articles'));
        }
        $this->template->article_list = View::factory('article_list')->set('articles',$article_list)->render();
    }

    private function _prepare_banners() {
        $b= new Banner_Model();
        $this->template->banners = View::factory('banners')->set('banners',$b->getBanners())->render();
    }

   private function _find_location() {
        $iploc = $this->session->get('ipLoc');        
        if(!$iploc) {
            if(strpos($_SERVER['REMOTE_ADDR'], '192.168.1')!==false ) $_SERVER['REMOTE_ADDR'] = '';
            $url = 'http://ipinfodb.com/ip_query.php?output=json&ip='.$_SERVER['REMOTE_ADDR'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $res =  curl_exec($ch);             
            if($res)  $this->session->set('ipLoc',json_decode($res));           
        }
    }

    public function setFilter(){
        // retrieve page that we want to filter
        
        $lp = $this->session->get('current-page');
        if(isset($_POST['filter'])) $lp = $_POST['filter'];
        // retrieve already set filters
        $lp = explode('/',$lp);
        if(count($lp)<2) $lp = $lp[0].'/index'; else $lp = $lp[0].'/'.$lp[1];
        $filters = $this->session->get($lp, array('filters'=>''));
        //if we pass a reset_filter parametr ... cancel all previous filters
        if(isset($_POST['reset'])) $filters['filters'] = array();

        unset($_POST['reset']);
        unset($_POST['filter']);
        // now add everything passed in as a filter. also do a basic filtering
        //TODO: do a basic filtering - not needed kohana is safe for SQL inj. and XSS filtering        
        foreach($_POST as $k=>$v) {
            $filters['filters'][$k] = $v;
        }
        
        $this->session->set($lp,$filters);        
        if(!request::is_ajax())url::redirect($lp);


    }

    public function sort($field,$desc=false,$sort=false,$reset=false){
        
        $lp = $this->session->get('current-page');
        // separate just controller/method
        $lp = explode('/',$lp);
        if(count($lp)<2) $lp = $lp[0].'/index'; else $lp = $lp[0].'/'.$lp[1];

        if($sort) $lp = $sort; // just in case we want to sort any other page, mainly for AJAX
        $settings = $this->session->get($lp,array('sort'=>array()));        
        if($reset) $settings['sort'] = array(); // want a reset of sort, Let it be
        if(isset($settings['sort']['field']) && $settings['sort']['field']!= $field ) $settings['sort']['desc'] = $desc;
        $settings['sort']['field'] = $field;

        if(!$desc){// no-desc specified, auto toggle
            
            if(!isset($settings['sort']['desc']) || strtoupper($settings['sort']['desc'])=='DESC') {// already set up or - toggle
                $settings['sort']['desc']='ASC';
            } else {
                $settings['sort']['desc'] = 'DESC';
            }
        } else {
            $settings['sort']['desc']=$desc;
        }
            
        $this->session->set($lp,$settings);
        if(!request::is_ajax())url::redirect($lp);
    }

    public function upgrade(){
        $model = new Indikace_Model();
        $model->updateUrls();
        $model->updateIrefsTable();

        $model = new Category_Model();
        $model->updateUrls();

        $model = new Product_Model();
        $model->updateUrls();

        $model = new Vendor_Model();
        $model->updateUrls();

        $model = new Clanky_Model();
        $model->updateUrls();
        Cache::instance()->delete_all();
        $this->template->content = 'DONE';

    }

    public function goBack(){
        url::redirect($this->session->get('current-page'));
    }

}

?>