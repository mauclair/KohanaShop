Objednávka
 =========================

	V případě jakýchkoli dotazů či nejasnosí nás bez váhání kontaktuje.
			Email: info@bylinarstvi.cz
			Telefon: ?


    Vaše objednávka:
    -----------------------------

       Číslo objednávky: <?= $data["order_id"] ?>
       Datum objednávky: <?= $data["order_date"] ?>
       Stav objednávky: <?= $data["order_status"] ?>

       Objednané zboží
       ............................

Název                         |     množství     |      Cena/kus     |    Celkem
------------------------------+------------------+-------------------+---------------------
<?
         foreach($data["order_items"] as $item){
         	 echo  "". str_pad($item["product_name"],30," ", STR_PAD_BOTH) ."|".str_pad($item["product_quantity"],18," ",STR_PAD_LEFT)."|".str_pad(sprintf(CURRENCY_FORMAT,$item["product_item_price"]),19," ",STR_PAD_LEFT)."|";
         	 echo  str_pad(sprintf(CURRENCY_FORMAT,$item["product_price_all"]),19," ",STR_PAD_LEFT);
         }
?>
==============================+==================+===================+======================

	Součet(s DPH)   :   <?=str_pad(sprintf(CURRENCY_FORMAT, $data["order_subtotal"]),10," ",STR_PAD_LEFT) ?>
	Doprava         :   <?=str_pad(sprintf(CURRENCY_FORMAT,$data["order_shipping"]),10," ",STR_PAD_LEFT) ?>
	==============================
	Celkem          :   <?=str_pad(sprintf(CURRENCY_FORMAT,$data["order_total"]),10," ",STR_PAD_LEFT) ?>
<?
    foreach($data["taxes"] as $k=>$v) {
    	echo "\t".str_pad(trim($k),16).":   ".str_pad(sprintf(CURRENCY_FORMAT,$v ),10," ",STR_PAD_LEFT);
    }
?>

     Způsob dopravy :  <?=$data["order_shipping_type"] ?>
     Způsob platby  :  <?=$data["order_payment_method"] ?>

     Fakturační adresa
     ..............................
     Firma : <?=$data["pay_address"]["company"]?>
     Jméno : <?=$data["pay_address"]["title"]." ".$data["pay_address"]["first_name"]." ".$data["pay_address"]["middle_name"]." ".$data["pay_address"]["last_name"] ?>
     Adresa : <?=$data["pay_address"]["address_1"].",".$data["pay_address"]["address_2"] ?>
     Město : <?=$data["pay_address"]["city"] ?>
     Stát/region : <?=$data["pay_address"]["state"] ?>
     PSČ :  <?=$data["pay_address"]["zip"] ?>

     Adresa pro doručení
     ..............................
     Jméno : <?=$data["ship_address"]["title"]." ".$data["ship_address"]["first_name"]." ".$data["ship_address"]["middle_name"]." ".$data["ship_address"]["last_name"] ?>
     Adresa : <?=$data["ship_address"]["address_1"].",".$data["ship_address"]["address_2"] ?>
     Město : <?=$data["ship_address"]["city"] ?>
     Stát/region : <?=$data["ship_address"]["state"] ?>
     PSČ :  <?=$data["ship_address"]["zip"] ?>



 Děkujeme za Vaši objednávku. Na aktuální stav objednávky se po přihlášení můžete podívat na našich stránkách v sekci  [ Můj účet ].


 S pozdravem
     <?=$data["owner"] ?>



