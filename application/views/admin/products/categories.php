<div id="categories-list">
<?php foreach($categories as $category):?>
    <div id="category_id-<?$category->category_id?>">
        <?= $category->category_name?>
        <a class="small-button button-delete" href="<?= url::site('administrace/adminProducts/removeCategory/'.$product_id.'/'.$category->category_id)?>"><?= Kohana::lang('main.delete')?></a></div>
<?  endforeach;?>
</div>
<form method="post" action="<?= url::site('administrace/adminProducts/addCategory')?>">
    <div>
        <input type="hidden" id="product_id" name="product_id" value="<?= $product_id?>" />
        <?= form::dropdown('category_id',$categories_select) ?>
        <input type="submit" class="button button-add"  value="<?= Kohana::lang('main.add')?>" />
    </div>
</form>