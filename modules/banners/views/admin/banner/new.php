<form action="<?= url::site('adminBanner/add')?>" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><?= Kohana::lang('banners.title')?> - <?= Kohana::lang('main.add')?></legend>
        <div id="banner-item" class="right"></div>
        <label for="banner_file"><?= Kohana::lang('banners.banner_file')?></label>
        <span id="banner_file_upload"></span>
        <input type="hidden" id="banner_file" name="banner_file" value=""/><br />
        <input type="hidden" id="file_id" name="file_id" value=""/><br />
        <label for="banner_url"><?= Kohana::lang('banners.banner_url')?></label>
        <input type="text" id="banner_url" name="banner_url" value="" /><br />
        <label for="banner_group"><?= Kohana::lang('banners.banner_group')?></label>
        <?= form::dropdown('banner_group', $banner_groups)?><br />
        <label for="banner_width"><?= Kohana::lang('banners.banner_width')?></label>
        <input type="text" id="banner_width" name="banner_width" value="" /><br />
        <label for="banner_height"><?= Kohana::lang('banners.banner_height')?></label>
        <input type="text" id="banner_height" name="banner_height" value="" /><br />
        <label for="display_from"><?= Kohana::lang('banners.display_from')?></label>
        <input type="text" id="display_from" name="display_from" value="" /><br />
        <label for="display_to"><?= Kohana::lang('banners.display_to')?></label>
        <input type="text" id="display_to" name="display_to" value="" /><br />
        <label for="display_clicks"><?= Kohana::lang('banners.display_clicks')?></label>
        <input type="text" id="display_clicks" name="display_clicks" value="" /><br /><br />
        <div class="center">
            <input class="button icon-add" type="submit" value="<?= Kohana::lang('main.add')?>" />
        </div>
    </fieldset>
</form>

<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/swfobject.js "></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js "></script>
<script type="text/javascript">
    $(function(){
        $("#display_from").datepicker({dateFormat:'yy-mm-dd'});
        $("#display_to").datepicker({dateFormat:'yy-mm-dd'});

        $("#display_from").datepicker({dateFormat:'yy-mm-dd'});
        $("#display_to").datepicker({dateFormat:'yy-mm-dd'});

        $("#banner_file_upload").uploadify({
                'uploader' : 'js/uploadify/uploadify.swf',
                'script' : '<?= url::site('ajax/uploadTempBanner')?>',
                'cancelImg'  : 'js/uploadify/cancel.png',
                'fileDataName' : 'banner_file',
                'folder' : 'upload/images',
                'auto' : true,
                'scriptData' : {'banner_id' :-1},
                //'buttonText' : 'Upload',
                'buttonImg' : 'img/box_upload_48.png',
                width: 48,
                height : 48,
                wmode : 'transparent',
                'onComplete' : function(event,queueID,fileObj, response, data){
                    var ret = eval('('+response+')');                    
                    $("#banner_file").val(ret.banner_file);
                    $("#file_id").val(ret.file_id);
                    $("#banner-item").load('ajax/renderTempBanner',{
                        banner_width : $("#banner_width").val(),
                        banner_height: $('#banner_height').val(),
                        banner_url : $("#banner_url").val(),
                        banner_file : $("#banner_file").val()
                    });
                }
            });


    });
</script>