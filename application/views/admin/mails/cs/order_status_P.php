<h1>Objednávka</h1>
<p>	V případě jakýchkoli dotazů či nejasností nás bez váhání kontaktuje. <br />
        Email: <a href="mailto:prodej@bylinarstvi.cz" >prodej@bylinarstvi.cz</a><br />
        Telefon: <b>603 878 217</b>
</p>
     <h2>Vaše objednávka: </h2>
     <p style="color:red;">Objednávku je nutné <a href="<?=URL ?>?page=shop/confirmOrder&amp;onmbr=<?=$data["order_number"] ?>"> závazně potvrdit</a> tímto odkazem.
         <a href="<?= url::site('uzivatel/potvrdit_objednavku/'.$order_number)  ?>"><?= url::site('uzivatel/potvrdit_objednavku/'.$order_number)  ?></a>.</p>
 <?= $order ?>
 <p><strong>Bez potvrzení nebude objednávka vyřízena.</strong></p>
 <h2>Pokyny pro platbu</h2>
 <p>Platby převodem předem poukažte na č. účtu 1027010932/5500 a jako variabilní symbol k identifikaci Vaší platby použijte číslo Vaší objednávky.</p>
 <p>Děkujeme za Vaši objednávku.
        Aktuální stav objednávky  můžete  po přihlášení sledovat  na našich stránkách v sekci  <b><a href="http://www.bylinarstvi.cz">[ Můj účet ] </a></b>.</p>
 <p> Vaše <a href="http://www.bylinarstvi.cz">www.Bylinarstvi.cz</a></p>