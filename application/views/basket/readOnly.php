<h2><?= Kohana::lang('basket.title')?></h2>
<table class="cartTable">
    <thead>
        <tr>
            <th><?= Kohana::lang('product.product_name')?></th>
            <th><?= Kohana::lang('product.product_price')?>*</th>
            <th><?= Kohana::lang('basket.count')?></th>
            <th><?= Kohana::lang('basket.sum')?>*</th>
            
        </tr>
     </thead>
     <tbody>
        <? foreach($data as $k=>$i):
            $prize = Product_Model::getPrize($i['data']);
            $prize_fmt = View::factory('product/prize')
                        ->set('tax',$i['data']['product_taxes_value'])
                        ->set('prize',$i['data']['product_price'])
                        ->set('discount',$i['data']['product_discount_id']);
            $celkem  = $i['count'] * $prize['prize'];
        ?>
        <tr>
            <td><a href="<?= url::site('produkt/'.$i['data']['product_url'])?>"><?= $i['data']['product_name']?></a></td>
            <td class="cena"><?= $prize_fmt ?></td>
            <td class="center"><?= $i['count']?></td>
            <td class="cena"><?= sprintf(Kohana::config('main.default-currency-format'),$celkem)?></td>            
        </tr>
        <?endforeach;?>
     </tbody>
     <tfoot>
         <tr>
             <td style="text-align: right;" colspan="3"><?= Kohana::lang('basket.sum-all')?>* :</td>
             <td class="cena"><?=  sprintf(Kohana::config('main.default-currency-format'),$sums['sum'])?></td>             
        </tr>
     </tfoot>
</table>