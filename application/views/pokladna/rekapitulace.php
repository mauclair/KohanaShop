<h1><?= Kohana::lang('pokladna.rekapitulace')?></h1>
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
            <a href="<?= url::site('pokladna/adresa')?>"><?= Kohana::lang('main.edit')?></a>
        </td>        
    </tr>
</table>
<?= $basket ?>

<h2></h2>
<table>
    <tr>
        <td>Zboží</td>
        <td><?= $sums['sum']?></td>
        <td></td>
    </tr>
    <tr>
        <td>Doprava</td>
        <td><?= $shipping['shipping_cost'] = $sums['sum'] >= $shipping['shipping_limit'] ? 0 : $shipping['shipping_cost'] ?></td>
        <td><? if($shipping['shipping_cost']>0) : ?>* <?= $shipping['shipping_limit'] - $sums['sum']?> <?= Kohana::lang('shipping.remains-to-free')?><?endif;?></td>
    </tr>
    <tr>
        <td>Zboží</td>
        <td><?= $sums['sum']?></td>
        <td></td>
    </tr>
</table>


