<h1><?= $product_name?> - <a href="<?= url::site('produkt/'.$product_url)?>"><?= Kohana::lang('main.show')?></a></h1>
<form action="<?= url::site('administrace/adminProducts/update')?>" method="post">
    <fieldset id="product_info">
        <legend><?= Kohana::lang('main.edit')?></legend>
        <label for="product_name"><?= Kohana::lang('product.product_name') ?></label>
        <input type="text" id="product_name"  name="product_name" class="required" value="<?= $product_name?>" /><br />

        <label for="product_url"><?= Kohana::lang('product.product_url') ?></label>
        <input type="text" id="product_url" name="product_url" value="<?= $product_url?>" /> <br />

        
        

        <input type="hidden" id="product_id" name="product_id" value="<?= $product_id?>" />
        <input type="submit" value="<?= Kohana::lang('main.save')?>" />
    </fieldset>
</form>