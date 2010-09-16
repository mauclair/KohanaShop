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
        <label class="float" for="vendor_id"><?= Kohana::lang('product.vendor_id')?></label>
        <?= form::dropdown('vendor_id',$vendors, $vendor_id)?>
    </fieldset>
    <fieldset>
        <legend>-</legend>
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
        <legend> Stav produktu </legend>

        <label for="product_publish">Publikovat?: </label>
        <input type="checkbox" name="product_publish" id="product_publish" value="Y"  >

        <label for="product_special">V akci: </label>
        <input type="checkbox" value="Y" name="product_special" id="product_special"    />



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

              </fieldset>

