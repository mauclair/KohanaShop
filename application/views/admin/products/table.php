<form id="filter" action="<?= url::site('administrace/adminProducts/setFilter')?>" method="post">
    <div>        
        <label for="product_publish"><?= Kohana::lang('product.product_publish') ?></label>
        <?= form::dropdown('product_publish',
                    array(
                        '',
                        'Y'=>Kohana::lang('product.product_publish_value.Y'),
                        'N'=>Kohana::lang('product.product_publish_value.N')
                      ), $filters['product_publish'])?>
        <label for="product_special"><?= Kohana::lang('product.product_special') ?></label>
        <?= form::dropdown('product_special',
                    array(
                        '-',
                        'Y'=>Kohana::lang('main.yes'),
                        'N'=>Kohana::lang('main.no')
                      ), $filters['product_special'])?>
        <label for="vendor_id"><?= Kohana::lang('vendor.vendor_name') ?></label>
        <?= form::dropdown('vendor_id',
                   $vendors, $filters['vendor_id'])?>

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
        <td><a href="<?= url::site('administrace/adminProducts/toggle/'.$product->product_id.'/product_publish')?>" rel="product_publish" class="toggler"><img src="imgs/icons/circle_<?= $product->product_publish?'green':'red'?>.png" alt="<?= $product->product_publish?>"/></a></td>
        <td><?= $product->product_price?></td>
        <td><a href="<?= url::site('administrace/adminProducts/delete/'.$product->product_id)?>" class="confirm" title="<?= Kohana::lang('main.confirm-delete')?>"><?= Kohana::lang('main.delete')?></a></td>
    </tr>
    <?endforeach;?>
</table>
<?= $pagination?>
<script type="text/javascript">
    $(function(){
        
        $('.toggler').click(function(event){
            var obj = $(this);
            var field = obj.attr('rel');
            obj.html('<img src="imgs/ajax-loader.gif" />')
            function updateObject(data){
                if(data[field]!=undefined){
                    var color =  data[field] ? 'green' : 'red';
                    obj.html('<img src="imgs/icons/circle_'+color+'.png" alt=""/>');
                }
            }

            $.post(obj.attr('href'), {}, updateObject, 'json')
            event.preventDefault();
        });
    });
</script>