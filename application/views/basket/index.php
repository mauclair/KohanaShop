<h1><?= Kohana::lang('basket.title')?></h1>
<?
    $sums = Basket_Model::sums();
    echo View::factory('basket/addbycode');
?>

<form method="post" action="<?= url::site('kosik/prepocitat')?>">
<table class="cartTable">
    <thead>
        <tr>
            <th><?= Kohana::lang('product.product_name')?></th>
            <th><?= Kohana::lang('product.product_price')?>*</th>
            <th><?= Kohana::lang('basket.count')?></th>
            <th><?= Kohana::lang('basket.sum')?>*</th>
            <th colspan="2"></th>
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
            <td class="center"> <input type="text" value="<?= $i['count']?>" name="quantity[<?=$k?>]" class="w05"></td>
            <td class="cena"><?= sprintf(Kohana::config('main.default-currency-format'),$celkem)?></td>
            <td class="center">  <a href="<?= url::site('kosik/odebrat/'.$k)?>"><img title="Smazat" alt="Smazat" src="img4/delete.gif"></a></td>
        </tr>
        <?endforeach;?>
     </tbody>
     <tfoot>
         <tr>
             <td style="text-align: right;" colspan="3"><?= Kohana::lang('basket.sum-all')?>* :</td>
             <td class="cena"><?=  sprintf(Kohana::config('main.default-currency-format'),$sums['sum'])?></td>
             <td class="center"><input type="submit" value="<?= Kohana::lang('basket.recount')?>" name="Update"></td>
        </tr>
     </tfoot>
</table>
</form>

