<form action="<?= url::site('adminBannerCategories/add')?>" method="post">
    <fieldset>
        <legend><?= Kohana::lang('main.add')?></legend>
        <label for="bannerCategory_name"><?= Kohana::lang('bannercategory.bannerCategory_name')?></label>
        <input type="text" id="bannerCategory_name" name="bannerCategory_name" value="" class="required"/><br />
        <label for="bannerCategory_slots"><?= Kohana::lang('bannercategory.bannerCategory_slots')?></label>
        <input type="text" id="bannerCategory_slots" name="bannerCategory_slots" value="" /><br />
        <label for="bannerCategory_html_id"><?= Kohana::lang('bannercategory.bannerCategory_html_id')?></label>
        <input type="text" id="bannerCategory_html_id" name="bannerCategory_html_id" value="" class="required"/><br /><br />
        <div class="center">
        <input class="button icon-add" type="submit" value="<?= Kohana::lang('main.add')?>" />
        </div>
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