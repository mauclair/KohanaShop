<?
    $dir = './img4/'.str_replace('_', '', $_SESSION['lang']).'/';
    
    $shop_link = $dir.'on/shop.png';
    $articles_link = $dir.'on/articles.png';
    $qa_link = $dir.'on/qa.png';
?>
<div id="leftMenuBar">
    <a href="<?=url::site('shop')?>" title="<?= Kohana::lang('shop.title')?>">
        <img src="<?=$shop_link?>" alt="<?= Kohana::lang('shop.title')?>" />
   </a>
    <a href="<?=url::site('clanky')?>" title="<?= Kohana::lang('clanky.title')?>">
        <img src="<?=$articles_link?>" alt="<?=Kohana::lang('clanky.title')?>" />
   </a>
    <a href="<?= url::site('poradna')?>" title="<?= Kohana::lang('poradna.title')?>">
      <img src="<?=$qa_link?>"  alt="<?= Kohana::lang('poradna.title')?>" />
   </a>   
</div>
