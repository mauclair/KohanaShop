<h1>Děkujeme za vaši registraci</h1>  
  <p>V případě jakýchkoli dotazů či nejasnosí nás bez váhání kontaktuje. </p>
  <ul>
    <li>  Email: <a href="mailto:prodej@bylinarstvi.cz" >prodej@bylinarstvi.cz</a> </li>
  </ul>
 <p>Doporučujeme si tento email dobře uschovat, obsahuje vaše přihlašovací údaje.</p> 
 <h2>Vaše registrace: </h2>    
<ul>
   <li>Login: <?= $username ?> </li>
   <li>Heslo: <?= $password_1 ?> </li>
   <li>email: <?= $user_email ?> </li>
   <li>Jméno: <?= $first_name ?> <?= $middle_name ?> <?= $last_name ?></li>
<?if($company) {?><li>Firma: <?= $company ?> </li><? } ?>
<?if($ico) {?><li>IČO: <?= $ico ?> </li><? } ?>
<?if($dico) {?><li>DIČ: <?= $dico ?> </li><? } ?>
   <li>Adresa: <?= $address_1 ?> <?= $address_2 ?></li>
   <li>Město: <?= $city ?> </li>
   <li>Psč: <?= $zip ?> </li>
   <li>Telefon: <?= $phone_1 ?> </li>
<?if($fax) {?><li>Fax: <?= $fax ?> </li><? } ?>
</ul>        
<p>Veškerou správu svého účtu a  zobrazení stavu objednávek  můžete po přihlášení provést v sekci <a href="http://www.bylinarstvi.cz?page=account/index">Můj účet</a> 
na našich <a href="http://www.bylinarstvi.cz">stránkách</a></p>

<p>Pokud potřebujete poradit s nějakým zdravotním problémem, či zjistit více informací o jednotlivých produktech, můžete tak
   provést v naší <a href="http://www.bylinarstvi.cz?page=shop/poradna"> poradně</a>, nebo můžete poslat email na <a href="mailto:info@bylinarstvi.cz">info@bylinarstvi.cz</a>
</p>   

<p>
   Pokud vám nevyhovuje objednávání přes webové rozhraní, můžete objednávku provést i telefonicky na čísle <b>603 878 217</b>. 
	Doporučejeme si předem zjistit kódy výrobků, urychlí to vyřízení Vaší objednávky k Vaší plné spokojenosti, ačkoli Vaši objednávku 
	rádi vyřídíme i bez nich.  
</p>          

<p> Vaše <a href="http://www.bylinarstvi.cz">www.Bylinarstvi.cz</a>.</p>
      
</body>       
      
</html>