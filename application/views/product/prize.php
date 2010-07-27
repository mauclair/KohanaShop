<?
 $taxmul = 1.0 + $tax * 0.01;
 $oprize = $prize * $taxmul;
 $nprize = $oprize * (1.0 - $discount  * 0.01 );
?>
 <?if($discount):?><del><?= format::prize($oprize) ?></del><?endif;?>
 <?= format::prize($nprize) ?>
