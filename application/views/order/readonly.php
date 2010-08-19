<h1><?= Kohana::lang('orders.order_number') ?>: <?= $order_number ?></h1>

<table>
    <tr>
        <td>
            <h2><?= Kohana::lang('user.billing-address') ?></h2>
            <?= $billing_address ?>
        </td>
        <td>
            <h2><?= Kohana::lang('user.shipping-address') ?></h2>
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
            $sums = array('sum'=>0,'count'=>0);
            foreach ($items as $item):
                $sums['sum'] += $item->product_item_price;
                $sums['count'] += $item->product_quantity;
    ?>
                <tr>
                    <td><a href="<?= url::site('produkt/'.$item->product_url)?>"><?= $item->product_name ?></a></td>
                    <td><?= $item->product_quantity ?></td>
                    <td><?= $item->product_taxes_value ?>%</td>
                    <td class="right"><?= format::prize( $item->product_item_price) ?></td>
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
                        <td><?=format::prize( $sums['sum'] + $shipping['shipping_cost']) ?></td>
                        
                    </tr>
                </table>
<? /*
                      <div>
                      <h2><label for="poznamka"><?= Kohana::lang('pokladna.poznamka')?></label></h2>
                      <textarea name="poznamka" id="poznamka" rows="10" cols="60"></textarea>
                      <br />
                      <input type="submit" class="button" value="<?= Kohana::lang('pokladna.potvrtdit-dokoncit')?>">
                      </div>




                     */ ?>