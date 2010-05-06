<form action="<?= url::site('adminBanner/update')?>" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><?= Kohana::lang('banners.title')?> - <?= Kohana::lang('main.update')?></legend>
        <div class="right" id="banner-item" style="width:250px; height : 400px; overflow:hidden;"><?= $banner_item?></div>
        <label for="banner_file"><?= Kohana::lang('banners.banner_file')?></label>
        <input type="file" id="banner_file" name="banner_file" value=""/><br />
        <label for="banner_url"><?= Kohana::lang('banners.banner_url')?></label>
        <input type="text" id="banner_url" name="banner_url" value="<?=$banner_url?>" /><br />
        <label for="banner_group"><?= Kohana::lang('banners.banner_group')?></label>
        <?= form::dropdown('banner_group', $banner_groups, $banner_group)?><br />
        <label for="banner_width"><?= Kohana::lang('banners.banner_width')?></label>
        <input type="text" id="banner_width" name="banner_width" value="<?=$banner_width?>" /><br />
        <label for="banner_height"><?= Kohana::lang('banners.banner_height')?></label>
        <input type="text" id="banner_height" name="banner_height" value="<?=$banner_height?>" /><br />
        <label for="display_from"><?= Kohana::lang('banners.display_from')?></label>
        <input type="text" id="display_from" name="display_from" value="<?=$display_from?>" /><br />
        <label for="display_to"><?= Kohana::lang('banners.display_to')?></label>
        <input type="text" id="display_to" name="display_to" value="<?=$display_to?>" /><br />
        <label for="display_clicks"><?= Kohana::lang('banners.display_clicks')?></label>
        <input type="text" id="display_clicks" name="display_clicks" value="<?=$display_clicks?>" /><br /><br />
        <div class="center">
            <a onclick="$('form').submit()" class="icon-save button"><?= Kohana::lang('main.save')?></a>
            <input type="submit" value="<?= Kohana::lang('main.save')?>" class="hide" />
            <a class="confirm icon-delete button" href="<?= url::site('adminBanner/delete/'.$banner_id)?>"><?= Kohana::lang('main.delete')?></a>
        </div>
        <input type="hidden" value="<?=$banner_id?>" name="banner_id" />
    </fieldset>
</form>

<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/swfobject.js "></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js "></script>
<script type="text/javascript">

    $(function(){
        $("#display_from").datepicker({dateFormat:'yy-mm-dd'});
        $("#display_to").datepicker({dateFormat:'yy-mm-dd'});
        //*$("#banner-item").load('adminBanner/getItem/<?=$banner_id?>');

        $("#banner_file").uploadify({
                'uploader' : 'js/uploadify/uploadify.swf',
                'script' : '<?= url::site('ajax/uploadBanner')?>',
                'cancelImg'  : 'js/uploadify/cancel.png',
                'fileDataName' : 'banner_file',
                'folder' : 'upload/images',
                'auto' : true,
                'scriptData' : {'banner_id' : <?= $banner_id ?>},
                //'buttonText' : 'Upload',
                'buttonImg' : 'img/box_upload_48.png',
                width: 48,
                height : 48,
                wmode : 'transparent',
                'onAllComplete' : function(event,queueID,fileObj, response, data){
                    $("#banner-item").load('adminBanner/getItem/<?=$banner_id?>');
                }
            });
            
    });
</script>