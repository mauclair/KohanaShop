<?
    $href  = url::site('produkt/'.$product_url);
    $image = 'images/product/small/'.$product_thumb_image;    
    $form = View::factory('product/form')->set('product_id',$product_id)->render();
    //$i_refs = '';

?>
<div class="productItem">
<table><tr><th class="title"><h3><a href="<?=$href?>"><?=$product_name?></a></h3></th></tr></table>
<div class="image"><a href="<?=$href?>"><img src="<?=$image?>" alt="<?=$product_name?>" title="<?=$product_s_desc?>"/></a></div>
<div class="price"> 
    <?= View::factory('product/prize')->set('tax',$product_taxes_value)->set('discount',$product_discount_id)->set('prize',$product_price)->render()?>
    <?=$form ?>
</div>
<p class="desc"><span class="small"><a href="<?= url::site('vyrobce/'.$vendor_url)?>"><?=$vendor_name?></a>, <?= $indikace?></span><br /><br /><?=$product_s_desc ?></p>
</div>