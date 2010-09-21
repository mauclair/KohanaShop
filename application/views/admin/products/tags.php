<div id="indikace-list">
<?php foreach($tags as $tag):?>
    <div id="indikace_id-<?$tag->indikace_id?>">
        <?= $tag->indikace_name?>
        <a class="small-button delete" href="<?= url::site('administrace/adminProducts/removeTag/'.$product_id.'/'.$tag->indikace_id)?>"><?= Kohana::lang('main.delete')?></a></div>
<?  endforeach;?>
</div>
<form method="post" action="<?= url::site('administrace/adminProducts/addTag')?>">
    <div>
        <input type="hidden" id="product_id" name="product_id" value="<?= $product_id?>" />
        <?= form::dropdown('indikace_id',$tag_select) ?>
        <input type="submit"  value="<?= Kohana::lang('main.add')?>" />
    </div>
</form>