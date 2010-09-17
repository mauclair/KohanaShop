<form id="filter" action="<?= url::site('administrace/adminProducts/setFilter')?>" method="post">
    <div>        
        <label for="product_publish"><?= Kohana::lang('product.product_publish') ?></label>
        <?= form::dropdown('product_publish',
                    array(
                        Kohana::lang('main.dont-care'),
                        'Y'=>Kohana::lang('main.yes'),
                        'N'=>Kohana::lang('main.no')
                      ), $filters['product_publish'])?>
        <label for="product_special"><?= Kohana::lang('product.product_special') ?></label>
        <?= form::dropdown('product_special',
                    array(
                        Kohana::lang('main.dont-care'),
                        'Y'=>Kohana::lang('main.yes'),
                        'N'=>Kohana::lang('main.no')
                      ), $filters['product_special'])?>
        <label for="vendor_id"><?= Kohana::lang('product.vendor_id') ?></label>
        <?= form::dropdown('vendor_id', $vendors, $filters['vendor_id'])?>

        <input type="submit" value="<?= Kohana::lang('main.filter')?>" />

    </div>
</form>
<?= $pagination?>
<table>
    <tr>
        <th><?= show::asort(Kohana::lang('product.product_name'), 'product_name',$sort)  ?></th>
        <th><?= show::asort(Kohana::lang('product.product_publish'),'product_publish',$sort) ?></th>
        <th><?= show::asort(Kohana::lang('product.product_price'),'product_price',$sort) ?></th>
        <th></th>
    </tr>
    <?foreach($data as $product):?>
    <tr <?= text::alternate('class="even"','')?>>
        <td><a href="<?= url::site('administrace/adminProducts/edit/'.$product->product_url)?>"><?= $product->product_name?></a></td>
<? $publish_class = $product->product_publish == 'Y' ? 'button-on' : ''?>
<? $special_class = $product->product_special == 'Y' ? 'button-on' : ''?>
        <td>
            <a href="<?= url::site('administrace/adminProducts/toggle/'.$product->product_id.'/product_publish')?>" rel="product_publish" class="toggler small-button <?=$publish_class?>"><?= Kohana::lang('product.product_publish')?></a>
            <a href="<?= url::site('administrace/adminProducts/toggle/'.$product->product_id.'/product_special')?>" rel="product_special" class="toggler small-button <?=$special_class?>"><?= Kohana::lang('product.product_special')?></a>
        </td>
        <td><?= $product->product_price?></td>
        <td><a href="<?= url::site('administrace/adminProducts/delete/'.$product->product_id)?>" class="confirm" title="<?= Kohana::lang('main.confirm-delete')?>"><?= Kohana::lang('main.delete')?></a></td>
    </tr>
    <?endforeach;?>
</table>
<?= $pagination?>