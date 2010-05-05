<?php
class Clanky_Model extends Table_Model{
    public $table = 'clanky';
    public $id = 'cid';
    public $autoUrl = array('title'=>'clanky_url');

    public function updateUrls(){
        $d = $this->fetch();
        foreach ($d as $c){
            $c = (array)$c;
            //echo $c['title'];
            $c['clanky_url'] = '';
            $this->update($c);
        }
    }

    public function convertAllToHtml(){
        $texy = new Texy();
        $cs = $this->fetch();
        foreach($cs as $c){
            $c = (array) $c;
            $c['body'] = $texy->process($c['body']);
            $this->update($c);
        }
    }
}
?>
