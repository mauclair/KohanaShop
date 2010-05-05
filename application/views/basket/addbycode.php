<form action="kosik/pridatKod" method="post">
    <fieldset>
        <legend><?= Kohana::lang('basket.add-by-code')?></legend>
        <label for="product_code"><?= Kohana::lang('product.product_code')?></label>
        <input type="text" name="product_code"  class="w1" id="product_code" value="" />
        <label for="count"><?= kohana::lang('basket.count')?></label>
        <input type="text" id="count" name="count" class="w05" value="1" />
        <input type="submit" value="<?= Kohana::lang('main.add')?>" />
    </fieldset>
</form>