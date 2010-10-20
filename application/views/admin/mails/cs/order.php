<p>Číslo objednávky: <?= $order_number ?><br />
Datum objednávky: <?= $order_date ?> </p>
<h3>Objednané zboží </h3>
<table style="width:98%;">
	<tr>
          <th>Kód</th> <th> Název </th> <th> množství  </th> <th> Cena/kus </th> <th> Celkem </th>
         </tr>
<?
         foreach($order_items as $item){
         	 ?>
         	   <tr>
         	    <td> <?= $item["product_code"] ?></td>
         	    <td> <?= $item["product_name"] ?></td>
         	    <td> <?= $item["product_quantity"] ?></td>
         	    <td> <?= currency_format($item["product_item_price"]) ?></td>
         	    <td> <?= currency_format($item["product_price_all"]) ?></td>
         	   </tr>
         	 <?
         }
?>
    <tr> <td colspan="2"></td><td>	Součet(s DPH)   :</td> <td style="text-align: right"><?= currency_format($order_subtotal) ?> </td> </tr>
	<tr> <td colspan="2"></td><td>  Doprava         :  </td><td style="text-align: right"><?=currency_format($order_shipping) ?> </td></tr>

	<tr> <td colspan="2"></td> <td> Celkem          :  </td> <td style="text-align: right;font-size:larger; font-weight:bold;"><?=currency_format($order_total) ?> </td> </tr>
	<tr> <td colspan="4"> DPH rekapitulace </td></tr>
<?
    foreach($taxes as $k=>$v) {
    	?>
    	<tr> <td colspan="2"></td> <td>  <?=$k?> : </td> <td style="text-align: right"><?= currency_format($v ) ?> </td></tr>
    	<?
    }
?>
</table>
 <p>Způsob dopravy :  <?=$order_shipping_type ?></p>

 <table>
  <tr><td><h3>Fakturační adresa </h3>
  
</td><td>
  <h3> Adresa pro doručení</h3>
  
</td></tr> 
 </table>
 <? if( $note):?>
 <table><tr>
         <td><b>Poznámka:</b></td>
         <td><?= $note?></td>
     </tr>
 </table>
<?endif;?>