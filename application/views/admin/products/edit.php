<h1><?= $product_name ?> - <a href="<?= url::site('produkt/' . $product_url) ?>"><?= Kohana::lang('main.show') ?></a></h1>
<div class="togglers">
    <?
    $publish_class = $product_publish == 'Y' ? 'button-on' : '';
    $special_class = $product_special == 'Y' ? 'button-on' : ''
    ?>
    <a href="<?= url::site('administrace/adminProducts/toggle/' . $product_id . '/product_publish') ?>" rel="product_publish" class="toggler small-button <?= $publish_class ?>"><?= Kohana::lang('product.product_publish') ?></a>
    <a href="<?= url::site('administrace/adminProducts/toggle/' . $product_id . '/product_special') ?>" rel="product_special" class="toggler small-button <?= $special_class ?>"><?= Kohana::lang('product.product_special') ?></a>
</div>
<form action="<?= url::site('administrace/adminProducts/update') ?>" method="post">
    <fieldset id="product_info">
        <legend><?= Kohana::lang('main.edit') ?></legend>
        <label for="product_name" class="float"><?= Kohana::lang('product.product_name') ?></label>
        <input type="text" id="product_name" name="product_name" value="<?= $product_name ?>"  />
        <label for="product_code" class="float"><?= Kohana::lang('product.product_code') ?> </label>
        <input type="text" name="product_code" id="product_code" value="<?= $product_code ?>" />
        <label for="PDK_kod" class="float"><?= Kohana::lang('product.PDK_kod') ?> </label>
        <input type="text" name="PDK_kod" id="PDK_kod" value="<?= $PDK_kod ?>" />
        <label class="float" for="product_url"><?= Kohana::lang('product.product_url') ?> </label>
        <input type="text" name="product_url" id="product_url" value="<?= $product_url ?>"  />

        <input type="hidden"  name="product_id" value="<?= $product_id ?>" />
        <label class="float" for="vendor_id"><?= Kohana::lang('product.vendor_id') ?></label>
<?= form::dropdown('vendor_id', $vendors, $vendor_id) ?>
        <label class="float" for="product_available_date"><?= Kohana::lang('product.product_available_date') ?></label>
        <input type="date" name="product_available_date" id="product_available_date" size="11" value="<?= $product_available_date ?>" />
        <label for="product_expiration_date"><?= Kohana::lang('product.product_expiration_date') ?></label>
        <input type="date" id="product_expiration_date" name="product_expiration_date" value="<?= $product_expiration_date ?>" />
        <input type="submit" class="button button-save" value="<?= Kohana::lang('main.save') ?>" />
    </fieldset>    
</form>
<ul class="tabs">
    <li><a href="administrace/adminProducts/categories/<?=$product_id?>"><?= Kohana::lang('product.categories') ?></a></li>
    <li><a href="administrace/adminProducts/indikace/<?=$product_id?>"><?= Kohana::lang('product.tags') ?></a></li>
    <li><a href="administrace/adminProducts/product_details/<?=$product_id?>"><?= Kohana::lang('product.details') ?></a></li>
    <li><a href="administrace/adminProducts/images/<?=$product_id?>"><?= Kohana::lang('product.images') ?></a></li>
</ul>
<div class="panes">
    <div style="display:block"><?= $categories ?></div>
</div>

<script type="text/javascript" src="scripts/wymeditor/jquery.wymeditor.pack.js"></script>
<script type="text/javascript" >
    $(function(){
        $(':date').dateinput();     
        $('.tabs').tabs('.panes>div',{history:true, effect:'ajax'});
    });
</script>