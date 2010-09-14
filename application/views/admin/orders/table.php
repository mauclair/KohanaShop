<form id="filter" action="<?= url::site('administrace/adminProducts/setFilter')?>" method="post">
    <div>        
        <label for="product_publish"><?= Kohana::lang('product.product_publish') ?></label>
        <?= form::dropdown('product_publish',
                    array(
                        '-',
                        'Y'=>Kohana::lang('product.product_publish_value.Y'),
                        'N'=>Kohana::lang('product.product_publish_value.N')
                      ), $filters['product_publish'])?>
        <label for="vendor_id"><?= Kohana::lang('vendor.vendor_name') ?></label>
        <?= form::dropdown('vendor_id',
                   $vendors, $filters['vendor_id'])?>

        <input type="submit" value="<?= Kohana::lang('main.filter')?>" />

    </div>
</form>
<?= $pagination?>
<table>
    <tr>
        <th><?= show::asort(Kohana::lang('orders.order_status'),'order_status') ?></th>
        <th><?= show::asort(Kohana::lang('orders.order_date'),'order_date') ?></th>
        <th><?= show::asort(Kohana::lang('users.user_name'),'user_name') ?></th>
        <th></th>
    </tr>
    <?foreach($data as $order):?>
    <tr>
        <td><a href="<?= url::site('administrace/adminProducts/edit/'.$product->product_url)?>"><?= $product->product_name?></a></td>
        <td><?= $product->product_publish?></td>
        <td><?= $product->product_price?></td>
        <td><a href="<?= url::site('administrace/adminProducts/delete/'.$product->product_id)?>" class="confirm" title="<?= Kohana::lang('main.confirm-delete')?>"><?= Kohana::lang('main.delete')?></a></td>
    </tr>
    <?endforeach;?>
</table>
<?= $pagination?>