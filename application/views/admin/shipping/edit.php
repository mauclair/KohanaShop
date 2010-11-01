<form action="<?= url::site('admionistrace/adminShipping/update')?>" method="post">
    <div>
        <label for="shipping_name"><?= Kohana::lang('shipping.shipping_name') ?></label>
        <input type="text" id="shipping_name" name="shipping_name" value="<?= $shipping_name?>" /><br />
        <label for="shipping_cost"><?= Kohana::lang('shipping.shipping_cost') ?></label>
        <input type="text" id="shipping_cost" name="shipping_cost" value="<?= $shipping_cost ?>" /><br />
        <label for="shipping_limit"><?= Kohana::lang('shipping.shipping_limit') ?></label>
        <input type="text" id="shipping_limit" name="shipping_limit" value="<?= $shipping_limit ?>" />

        <input type="submit" value="<?= Kohana::lang('main.save')?>" class="button button-save" />
     </div>
</form>
