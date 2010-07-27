<?php defined('SYSPATH') or die('No direct script access.');
  class error_Core {
		public static function add($val,$class='error'){
			$errors = Session::instance()->get('errors');
			if (is_array($val)){ foreach ($val as $v) $errors[]=array('value'=>$v,'class'=>$class); }
			else $errors[] = array('value'=>$val,'class'=>$class);;
			Session::instance()->set('errors',$errors);
		}
	 	public static function parseValidation($array){
			foreach ($array as $k=>$v){
				error_Core::add($k.'=>'.$v);
			}
	 	}

                public static function get($delete=true){
                    $e = Session::instance()->get('errors',array());
                    if($delete)Session::instance()->delete('errors');
                    return $e;
                }

                public static function render(){
                    $e = self::get();
                    if(!$e) return '';
                    return View::factory('errors')->set('errors',$e)->render();
                }
  }

?>