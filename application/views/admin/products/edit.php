<h1><?= $product_name?> - <a href="<?= url::site('produkt/'.$product_url)?>"><?= Kohana::lang('main.show')?></a></h1>
<form action="<?= url::site('administrace/adminProducts/update')?>" method="post">
    <fieldset id="product_info">
        <legend><?= Kohana::lang('main.edit')?></legend>
        <label for="product_name" class="float"><?= Kohana::lang('product.product_name')?></label>
        <input type="text" id="product_name" name="product_name" value="<?= $product_name?>"  />
        <label for="product_code" class="float"><?= Kohana::lang('product.product_code')?> </label>
        <input type="text" name="product_code" id="product_code" value="<?= $product_code?>" />
        <label for="PDK_kod" class="float"><?= Kohana::lang('product.PDK_kod')?> </label>
        <input type="text" name="PDK_kod" id="PDK_kod" value="<?= $PDK_kod?>" />
        <label class="float" for="product_url"><?= Kohana::lang('product.product_url')?> </label>
        <input type="text" name="product_url" id="product_url" value="<?= $product_url?>"  />        

        <input type="hidden" id="product_id" name="product_id" value="<?= $product_id?>" />
        <input type="submit" value="<?= Kohana::lang('main.save')?>" />
    </fieldset>
    <fieldset>
        <legend><?= Kohana::lang('product.product_categories')?></legend>
        <?= $categories ?>
    </fieldset>
    <fieldset>
        <legend><?= Kohana::lang('product.product_indication')?></legend>
        <h2><?= Kohana::lang('indication.title')?></h2>
        <?= $tags?>
    </fieldset>
</form>


          <fieldset>

        <legend>Informace</legend>
        
          <select name="category_id" id="category_id">
<option selected="selected" value="1">
&#151|1|&nbsp;Doplňky stravy</option><option value="2">
&#151|1|&nbsp;Vitamíny</option><option value="3">
&#151|1|&nbsp;Minerály</option><option value="4">
&#151|1|&nbsp;Stopové prvky</option><option value="5">
&#151|1|&nbsp;Výluhy z pupenů</option><option value="6">
&#151|1|&nbsp;Bylinné výtažky</option><option value="7">
&#151|1|&nbsp;Včelí produkty</option><option value="8">
&#151|1|&nbsp;Životabudiče</option><option value="9">
&#151|1|&nbsp;Čínská medicína</option><option value="10">
&#151|1|&nbsp;Esenciální oleje</option><option value="11">
&#151|1|&nbsp;Afrodiziaka</option><option value="12">
&#151|1|&nbsp;Byliny, bylinky</option><option value="13">
&#151|1|&nbsp;Čaje bylinné sypané</option><option value="14">
&#151|1|&nbsp;Čaje klasické</option><option value="15">
&#151|1|&nbsp;Čaje ovocné</option><option value="16">
&#151|1|&nbsp;Čaje ochucené</option><option value="17">
&#151|1|&nbsp;Čajové příslušenství</option><option value="18">
&#151|1|&nbsp;Ústní hygiena</option><option value="19">
&#151|1|&nbsp;Kosmetika</option><option value="20">
&#151|1|&nbsp;Tělová kosmetika</option><option value="21">
&#151|1|&nbsp;Vlasová kosmetika</option><option value="22">
&#151|1|&nbsp;Koření</option><option value="23">
&#151|1|&nbsp;Různé</option><option value="42">
&#151|1|&nbsp;Bylinářství cz</option><option value="41">
&#151|1|&nbsp;Lékořice</option><option value="71">
&#151|1|&nbsp;Knihy</option><option value="72">
&#151|1|&nbsp;Z Peru</option><option value="100">
&#151|1|&nbsp;Výprodej</option><option value="101">
&#151|1|&nbsp;Akce</option><option value="102">
&#151|1|&nbsp;Bylinné elixíry</option><option value="103">
&#151|1|&nbsp;Vodní řasy</option><option value="104">
&#151|1|&nbsp;Ayurveda</option><option value="105">
&#151|1|&nbsp;Léčivá kosmetika</option><option value="106">
&#151|1|&nbsp;Čaje bylinné porcované</option><option value="107">
&#151|1|&nbsp;Oleje</option><option value="109">
&#151|1|&nbsp;Nečaje</option><option value="110">
&#151|1|&nbsp;Čaje zelené</option><option value="111">
&#151|1|&nbsp;Čaje černé</option><option value="112">
&#151|1|&nbsp;Potraviny</option><option value="113">
&#151|1|&nbsp;Na hubnutí</option><option value="114">
&#151|1|&nbsp;Léčivé kůry</option><option value="115">
&#151|1|&nbsp;Rostlinné přípravky</option><option value="116">
&#151|1|&nbsp;Doplňky stravy</option><option value="117">
&#151|1|&nbsp;Sladidla</option><option value="118">
&#151|1|&nbsp;Bylinno-ovocný čaj</option><option value="119">
&#151|1|&nbsp;Bílé čaje</option><option value="120">
&#151|1|&nbsp;Zdravotní balíčky</option><option value="121">
&#151|1|&nbsp;Kvetoucí čaje</option></select>
        <label class="float" for="product_taxes_id">Daňová kategorie: </label>

<select  name="product_taxes_id"><option  class="light" value="1" selected="selected" >DPH 10%</option>
<option  value="2">DPH 20%</option>
</select>
        <label class="float" for="vendor_id">Výrobce <a class="Button" href="?page=vendor/vendor_form" ><small>Přidat</small></a> : </label>

<select  name="vendor_id"><option  class="light" value="8">1 Bylinářství CZ</option>
<option  value="61">A. Kempe</option>
<option  class="light" value="20">AchátPharma</option>
<option  value="64">Agrobac</option>
<option  class="light" value="28">Álma</option>
<option  value="66">Alter</option>
<option  class="light" value="65">Amino</option>
<option  value="62">Apotheke</option>
<option  class="light" value="63">Apotheke</option>
<option  value="13">Appo</option>
<option  class="light" value="53">Aromatis</option>
<option  value="14">Avicenna</option>
<option  class="light" value="45">Balán</option>
<option  value="58">Biora</option>
<option  class="light" value="59">Biora</option>
<option  value="57">Biora</option>
<option  class="light" value="16">Brainway</option>
<option  value="55">Calendula</option>
<option  class="light" value="26">Chemek</option>
<option  value="39">Chlorella centrum</option>
<option  class="light" value="7">Cosmos</option>
<option  value="74">Dacom Pharma</option>
<option  class="light" value="12">Dr. Popov</option>
<option  value="67">Dudek</option>
<option  class="light" value="68">Energy</option>
<option  value="78">GRESIK</option>
<option  class="light" value="76">GREŠÍK-NATURA</option>
<option  value="77">GREŠÍK-NATURA</option>
<option  class="light" value="70">Health link</option>
<option  value="69">Hemax</option>
<option  class="light" value="9">Herba Vitalis</option>
<option  value="21">HM-Harmonie</option>
<option  class="light" value="46">Horn</option>
<option  value="30">Indie</option>
<option  class="light" value="54">Mag. Kotas</option>
<option  value="56">Mag.Kotas</option>
<option  class="light" value="35">Martin Kolár</option>
<option  value="71">Medin terra</option>
<option  class="light" value="24">Morvet</option>
<option  value="36">Naděje</option>
<option  class="light" value="18">Naturprodukt</option>
<option  value="79">Nobilis Tilia</option>
<option  class="light" value="25">Novy</option>
<option  value="52">OmaImpex</option>
<option  class="light" value="6">Organic India</option>
<option  value="44">Oro Verde</option>
<option  class="light" value="34">Parma</option>
<option  value="50">Petr Rulc KC</option>
<option  class="light" value="41">Phoenix</option>
<option  value="4">Pleva</option>
<option  class="light" value="38">Podhorná</option>
<option  value="37">Rabštejn</option>
<option  class="light" value="32">Rusko</option>
<option  value="47">Ryor</option>
<option  class="light" value="49">Solex</option>
<option  value="75">Solex Agro</option>
<option  class="light" value="60">SPAGYRIA</option>
<option  value="2">SPAGYRIA</option>
<option  class="light" value="1" selected="selected" >Specchiasol </option>
<option  value="40">TML</option>
<option  class="light" value="43">Topinax</option>
<option  value="5">Topvet</option>
<option  class="light" value="72">ttt</option>
<option  value="29">VHI čaje</option>
<option  class="light" value="23">VitaHarmony</option>
<option  value="11">Wang</option>
<option  class="light" value="33">Zentrich</option>
</select>
    </fieldset>

    <fieldset>
        <legend> Stav produktu </legend>

        <label class="float" for="product_publish">Publikovat?: </label>
        <input style="display:block;" type="checkbox" name="product_publish" id="product_publish" value="Y"  >

        <label class="float" for="product_special">V akci: </label>
        <input style="display:block;" type="checkbox" value="Y" name="product_special" id="product_special"    />



        <label class="float" for="product_in_stock">Ve skladu: </label>
        <input type="text" name="product_in_stock" id="product_in_stock" value="1" size="10" />

                  <label class="float" for="product_available_date">Datum dostupnosti(DD.MM.YYYY): </label>
        <input type="text" name="product_available_date" id="product_available_date" size="11" value="">


                  <label class="float" for="product_expiration_date">Expirace(DD.MM.YYYY): </label>
        <input type="text" name="product_expiration_date" id="product_expiration_date" size="11" value="">

        <label class="float" for="product_discount_id">Sleva: </label>
        <input type="text" name="product_discount_id" id="product_discount_id" value="0"  />


    </fieldset>

    <fieldset>
        <legend></legend>
        <label class="float" for="product_s_desc">Krátký popis: </label>
        <textarea id="product_s_desc" name="product_s_desc" cols="50" rows="6" >N-OX   </textarea>
        <label  class="float" for="product_desc">Popis produktu: </label>
        <textarea id="product_desc" name="product_desc" cols="50" rows="10" >N-OX</textarea>

        <label class="float" for="contains">Složení: </label>
        <textarea id="contains" name="contains" cols="50" rows="6" ></textarea>

        <label class="float" for="warning">Upozornění: </label>
        <textarea id="warning" name="warning" cols="50" rows="6" ></textarea>

        <label class="float" for="aplication">Způsob užívání: </label>
        <textarea id="aplication" name="aplication" cols="50" rows="6" ></textarea>
    </fieldset>

    <!--  ***  Obrazky ** -->
    <fieldset>
        <legend>Obrázky</legend>
        <input type="hidden" name="product_thumb_image_curr" value="f931911102dfe41e4ded988bbceae586.jpg" />
        <input type="hidden" name="product_full_image_curr" value="" />
        <div style="float:right;"><img src="images/product/small/f931911102dfe41e4ded988bbceae586.jpg"  alt="N-OX" title="N-OX" /></div>
        <label class="float" for="product_thumb_image">Obrázek: </label>
        <input type="file" name="product_thumb_image" id="product_thumb_image"  />
    </fieldset>


    <fieldset>
        <legend></legend>
        <input type="hidden" name="product_id" value="2" />
        <input type="hidden" name="func" value="productUpdate" />
        <input type="hidden" name="page" value="product/product_display" />



        <input type="submit" class="Button"  value="Uložit" onClick="product_s_desc_guardar();product_desc_guardar();" />
        <input type="button" class="Button" value="Smazat" onClick="return deleteRecord('http://www.bylinarstvi.cz/?page=product/product_list&func=productDelete&amp;product_id=2&amp;product_parent_id=&amp;');" />

              </fieldset>
</form>
