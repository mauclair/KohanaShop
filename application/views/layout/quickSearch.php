<?
$keyword = '';
if (isset($_SESSION['keyword'])) $keyword = $_SESSION['keyword']; 
?>
<div id="quickSearch" >
    <form action="<?= url::site('search')?>" method="post" id="fSearch" >
        <div id="quickSearchField" >
            <input type="text"  name="keyword"  value="<?=$keyword ?>"/>                        
        </div>
    </form>
</div>
<div id="advancedSearch"><a href="<?=url::site('search/advanced')?>"><?= Kohana::lang('search.advanced') ?> </a></div>
