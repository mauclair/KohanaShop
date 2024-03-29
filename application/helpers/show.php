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

    public static function asort($text,$key,$sort=false){
        $res = false;
        $uri = url::current();
        $sort = Session::instance()->get($uri.'.sort',$sort);
        $desc = 'asc';
        if($sort && isset($sort['field']) && $sort['field']== $key){
            if(strtoupper($sort['desc'])=='ASC'){
                    $desc = 'desc';
                    $res = '<img src="imgs/icons/asc.png" alt="'.$key.' ASC" />';
                } else {
                    $res = '<img src="imgs/icons/desc.png" alt="'.$key.' DESC" />';
            }
        }
        return '<a href="'.url::site(URI_Core::instance()->segment(1).'/sort/'.$key.'/'.$desc).'">'.$text.' '.$res.'</a>';
    }
}
?>
