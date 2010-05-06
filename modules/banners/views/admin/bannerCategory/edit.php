<form action="<?= url::site('adminBannerCategories/update')?>" method="post">
    <fieldset>
        <legend><?= Kohana::lang('main.update')?></legend>
        <label for="bannerCategory_name"><?= Kohana::lang('bannercategory.bannerCategory_name')?></label>
        <input type="text" id="bannerCategory_name" name="bannerCategory_name" value="<?=$bannerCategory_name?>" class="required"/><br />
        <label for="bannerCategory_slots"><?=Kohana::lang('bannercategory.bannerCategory_slots')?></label>
        <input type="text" id="bannerCategory_slots" name="bannerCategory_slots" value="<?= $bannerCategory_slots?>" /><br />
        <label for="bannerCategory_html_id"><?=Kohana::lang('bannercategory.bannerCategory_html_id')?></label>
        <input type="text" id="bannerCategory_html_id" name="bannerCategory_html_id" value="<?=$bannerCategory_html_id?>" class="required"/><br /><br />
        <div class="center">
            <a onclick="$('form').submit()" class="icon-save button"><?= Kohana::lang('main.save')?></a>
            <input type="submit" value="<?= Kohana::lang('main.save')?>" class="hide" />
            <a class="confirm icon-delete button" href="<?= url::site('adminBannerCategories/delete/'.$bannerCategory_id)?>"><?= Kohana::lang('main.delete')?></a>

        </div>
        <input type="hidden" id="bannerCategory_id" name="bannerCategory_id" value="<?=$bannerCategory_id?>" /><br />
    </fieldset>
</form>

<script type="text/javascript" src="js/jquery-validate/jquery.validate.pack.js "></script>
<script type="text/javascript" src="js/jquery-validate/localization/messages_<?=session::instance()->get('lang','de')?>.js "></script>
<script type="text/javascript" >
    $(function(){
        $("form").validate({
            errorElement : 'small'
        });

    });
</script>