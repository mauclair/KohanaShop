<?php
class My_Controller extends Crud_Controller {

    public $template = 'mainTpl';
    public $cache;
    public $session;
    
    public function  __construct() {
        parent::__construct();
      //  $this->profiler = new Profiler();
        $this->cache = Cache::instance();
        $this->template->title='UNDEFINED';
        $this->template->content = 'UNDEFINED';        
        $this->session = Session::instance();
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

            $this->session->set('lang','_'.$lang);
            $this->session->set('lang_full',$lang_full);
            Kohana::config_set('locale', $lang_full);
        } else {
            Kohana::config_set('locale', $this->session->get('lang_full','en_US'));
        }
        
        

        
        
        

    }

    public function _render(){
        if(request::is_ajax()){
            echo $this->template->content;
            return;
            //echo $bitch;
        }
       // $this->template->content .= $this->profiler->render(true);
        $this->session->set('last-page',$this->session->get('current-page'));
        $this->session->set('current-page',url::current());
        $cats =  View::factory('layout/category_list')->set('categories', cacheControl::categories() )->render();
        $this->template->leftMenu = View::factory('layout/left_menu')->set('categories', $cats )->render();
        $this->template->topMenu = '';
        $this->template->loggedInfo = '';
        $this->template->minicart = View::factory('basket/minicart')->set(array('total'=>0,'total_count'=>Basket_Model::getCount()))->render();
        $this->template->langSwitch = View::factory('layout/lang_switch')->render();
        $this->template->currencySwitch = View::factory('layout/currency_switch')->render();
        $this->template->quickSearch = View::factory('layout/quickSearch')->render();
        $this->template->directLogin = View::factory('layout/directLogin')->render();
        $this->template->leftMenuBar = View::factory('layout/leftMenuBar')->render();
        $this->template->headerLinks = '';

        parent::_render();
    }
}

?>
