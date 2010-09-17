<form id="details-list" action="<?= url::site('administrace/adminProductDetails/update')?>">
<?php foreach($details as $detail):?>
    <div id="detail_id-<?$detail->id?>">
        <h3><label for="contains"><?= Kohana::lang('product_details.contains') ?></label></h3>
        <textarea id="contains" cols="40" rows="10" class="wymeditor" name="contains"><?= $detail->contains?>" </textarea>
        <h3><label for="warning"><?= Kohana::lang('product_details.warning') ?></label></h3>
        <textarea id="warning" cols="40" rows="10" class="wymeditor" name="warning"><?= $detail->warning?>" </textarea>
        <h3><label for="aplication"><?= Kohana::lang('product_details.application') ?></label></h3>
        <textarea id="aplication" cols="40" rows="10" class="wymeditor" name="aplication"><?= $detail->aplication?>" </textarea>
        <input type="hidden" id="id" name="id" value="<?= $detail->id?>" />
        <input type="submit" class="wymSubmit" value="<?= Kohana::lang('main.save')?>">
    </div>
<?  endforeach;?>
</form>