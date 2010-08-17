<h1><?= Kohana::lang('orders.order_number')?>: <?= $order_number?></h1>

<table>
    <tr>
        <td>
            <h2><?= Kohana::lang('user.billing-address')?></h2>
            <?=$billing_address?>
            <a href="<?= url::site('pokladna/adresa')?>"><?= Kohana::lang('main.edit')?></a>
        </td>
        <td>
            <h2><?= Kohana::lang('user.shipping-address')?></h2>
            <?=$shipping_address?>
            <?= $shipping_save_address_options?>
            <a href="<?= url::site('pokladna/adresa')?>"><?= Kohana::lang('main.edit')?></a>
        </td>
    </tr>
</table>
<?= $basket ?>

<h2></h2>
<table>
    <tr>
        <td><?= Kohana::lang('pokladna.items')?></td>
        <td><?= $sums['sum']?></td>
        <td><a href="<?= url::site('pokladna')?>"><?= Kohana::lang('main.edit')?></a></td>
    </tr>
    <tr>
        <td>Doprava</td>
        <td><?= $shipping['shipping_cost'] = $sums['sum'] >= $shipping['shipping_limit'] ? 0 : $shipping['shipping_cost'] ?></td>
        <td><? if($shipping['shipping_cost']>0) : ?>* <?= $shipping['shipping_limit'] - $sums['sum']?> <?= Kohana::lang('shipping.remains-to-free')?><?endif;?></td>
    </tr>
    <tr>
        <td><?= Kohana::lang('pokladna.total')?></td>
        <td><?= $sums['sum'] + $shipping['shipping_cost']?></td>
        <td></td>
    </tr>
</table>

    <div>
        <h2><label for="poznamka"><?= Kohana::lang('pokladna.poznamka')?></label></h2>
        <textarea name="poznamka" id="poznamka" rows="10" cols="60"></textarea>
        <br />
        <input type="submit" class="button" value="<?= Kohana::lang('pokladna.potvrtdit-dokoncit')?>">
    </div>




