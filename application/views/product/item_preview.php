<?
    $href  = url::site('product/detail/'.$product_id);
    $image = '';
    $price =  View::factory('product/price')->set('product_price',$product_price)->set('discount',$product_discount_id)->render();
    
    $form = View::factory('product/form')->set('product_id',$product_id)->render();
    //$i_refs = '';

?>
<div class="productItem">
<table><tr><th class="title"><h3><a href="<?=$href?>"><?=$product_name?></a></h3></th></tr></table>
<div class="image"><a href="<?=$href?>"><?=$image?></a></div>
<div class="price"> <?=$price?>  <?=$form ?></div>
<p class="desc"><span class="small"><a href="?page=shop/browse&amp;vendor_id=<?=$vendor_id?>"> <?=$vendor_name?></a>, <?= $indikace?></span><br /><br /><?=$product_s_desc ?></p>
</div>