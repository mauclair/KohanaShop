<?php
class Show_Core {
    public static function sort($key){
        $res = false;
        $uri = url::current();
        $sort = Session::instance()->get($uri.'.sort');        
        if($sort && isset($sort['field']) && $sort['field']== $key){
            if($sort['desc']=='ASC'){
                    $res = '<img src="imgs/icons/asc.png" alt="'.$key.' ASC" />';
                } else {
                    $res = '<img src="imgs/icons/desc.png" alt="'.$key.' ASC" />';
            }
        }
        return $res;
    }
}
?>
