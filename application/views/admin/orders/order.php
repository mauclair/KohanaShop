<h1><?= Kohana::lang('order.order_number') ?>: <?= $order_number ?></h1>
<table>
    <tr>
        <td>
            <strong><?= Kohana::lang('user.billing-address') ?></strong>
            <?= $billing_address ?>
        </td>
        <td>
            <strong><?= Kohana::lang('user.shipping-address') ?></strong>
            <?= $shipping_address ?>
        </td>
    </tr>
</table>
<table>
    <tr>
        <th></th>
        <th><?= Kohana::lang('basket.count') ?></th>
        <th><?= Kohana::lang('product_price.dph') ?></th>
        <th></th>
    </tr>
    <?
            $sums = array('sum' => 0, 'count' => 0);
            foreach ($items as $item):
                $sums['sum'] += $item->product_item_price;
                $sums['count'] += $item->product_quantity;
    ?>
    <tr <?= text::alternate('','class="even"')?>>
                    <td><a href="<?= url::site('produkt/' . $item->product_url) ?>"><?= $item->product_name ?></a></td>
                    <td><?= $item->product_quantity ?></td>
                    <td><?= $item->product_taxes_value ?>%</td>
                    <td class="right"><?= format::prize($item->product_item_price) ?></td>
                </tr>
    <? endforeach; ?>
            </table>
            <table class="right">
                <tr>
                    <td class="right"><?= Kohana::lang('pokladna.items') ?></td>
                    <td><?= format::prize($sums['sum']) ?></td>

                </tr>
                <tr>
                    <td class="right">Doprava</td>
                    <td><?= format::prize($order_shipping) ?></td>
                </tr>
                <tr>
                    <td class="right"><?= Kohana::lang('pokladna.total') ?></td>
                    <td><?= format::prize($sums['sum'] + $shipping['shipping_cost']) ?></td>

                </tr>
    <? if ($note): ?>
                    <tr><td colspan="2">
                            <h2><?= Kohana::lang('pokladna.poznamka') ?></h2>
                            <p><?= $note ?></p>
                        </td></tr>
    <? endif; ?>
</table>