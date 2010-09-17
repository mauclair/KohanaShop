<h1><?= $product_name?> - <a href="<?= url::site('produkt/'.$product_url)?>"><?= Kohana::lang('main.show')?></a></h1>
<div class="togglers">
    <? $publish_class = $product_publish == 'Y' ? 'button-on' : '';
           $special_class = $product_special == 'Y' ? 'button-on' : ''
?>
    <a href="<?= url::site('administrace/adminProducts/toggle/'.$product_id.'/product_publish')?>" rel="product_publish" class="toggler small-button <?=$publish_class?>"><?= Kohana::lang('product.product_publish')?></a>
    <a href="<?= url::site('administrace/adminProducts/toggle/'.$product_id.'/product_special')?>" rel="product_special" class="toggler small-button <?=$special_class?>"><?= Kohana::lang('product.product_special')?></a>
</div>
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
        <label class="float" for="product_available_date"><?= Kohana::lang('product.product_available_date')?></label>
        <input type="date" name="product_available_date" id="product_available_date" size="11" value="<?= $product_available_date?>">
        <label for="product_expiration_date"><?= Kohana::lang('product.product_expiration_date') ?></label>
        <input type="date" id="product_expiration_date" name="product_expiration_date" value="<?=$product_expiration_date?>" />
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
    <fieldset>
        <legend><?= Kohana::lang('product.product_details')?></legend>
        <?= $details ?>
    </fieldset>
    
</form>         
    

    <!--  ***  Obrazky ** -->
    <fieldset>
        <legend>Obrázky</legend>
        <input type="hidden" name="product_thumb_image_curr" value="f931911102dfe41e4ded988bbceae586.jpg" />
        <input type="hidden" name="product_full_image_curr" value="" />
        <div style="float:right;"><img src="images/product/small/f931911102dfe41e4ded988bbceae586.jpg"  alt="N-OX" title="N-OX" /></div>
        <label class="float" for="product_thumb_image">Obrázek: </label>
        <input type="file" name="product_thumb_image" id="product_thumb_image"  />
    </fieldset>


    
    <script type="text/javascript" src="scripts/wymeditor/jquery.wymeditor.pack.js"></script>
    <script type="text/javascript" >
        $(function(){
            $(':date').dateinput();
            $('.wymeditor').wymeditor({
                lang:'<?=$this->session->get('lang','cs')?>',
                logoHtml: '',
                stylesheet: 'styles/paragraphs.css',
                updateSelector: "#datails-save",
                updateEvent:    "click"

            });
        });
    </script>