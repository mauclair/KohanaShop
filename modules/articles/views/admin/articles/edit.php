<?
$lang  = Session::instance()->get('lang','de');
?>
<form action="<?= url::site('adminArticles/update')?>" method="post">
    <fieldset>
        <legend><?= $article_title?> - <?= Kohana::lang('main.edit')?></legend>
        <label for="article_title"><?= Kohana::lang('articles.article_title')?> <img  src="img/lang/<?=$lang?>.png" alt="<?=$lang?>"/></label>
        <input type="text" id="article_title" name="article_title" value="<?=$article_title?>" />
        <br />
        <label for="article_url"><?= Kohana::lang('articles.article_url')?></label>
        <input type="text" id="article_url" name="article_url" value="<?=$article_url?>" />
        <br />
        <label for="article_text"><?= Kohana::lang('articles.article_text')?> <img  src="img/lang/<?=$lang?>.png" alt="<?=$lang?>"/></label><br />
        <textarea name="article_text" id="article_text" cols="70" rows="30"><?= $article_text?></textarea>
        <br />
        <input type="hidden" name="article_id" value="<?=$article_id?>"/>        
        <div class="center">
            <a onclick="$('form').submit()" class="icon-save button"><?= Kohana::lang('main.save')?></a>
            <input type="submit" value="<?= Kohana::lang('main.save')?>" class="hide" />
            <a class="confirm icon-delete button" href="<?= url::site('adminArticles/delete/'.$article_id)?>"><?= Kohana::lang('main.delete')?></a>
        </div>
    </fieldset>
</form>
<div> </div>


<script type="text/javascript" src="js/wymeditor/jquery.wymeditor.pack.js"></script>
<script type="text/javascript" >
  $("#article_text").wymeditor({
        lang : '<?= Session::instance()->get('lang','de')?>',
         boxHtml:   "<div class='wym_box'>"
              + "<div class='wym_area_top'>"
              + WYMeditor.TOOLS
              + "</div>"
              + "<div class='wym_area_left'></div>"
              + "<div class='wym_area_right'>"
              + WYMeditor.CONTAINERS
              + "</div>"
              + "<div class='wym_area_main'>"
              + WYMeditor.HTML
              + WYMeditor.IFRAME
              + WYMeditor.STATUS
              + "</div>"
              + "<div class='wym_area_bottom'>"
              + WYMeditor.LOGO
              + "</div>"
              + "</div>",
            updateSelector: "form",
            updateEvent:    "submit",

         logoHtml : '',
         postInit: function(wym) {
            //render the containers box as a panel
            //and remove the span containing the '>'
            jQuery(wym._box).find(wym._options.containersSelector)
                .removeClass('wym_dropdown')
                .addClass('wym_panel')
                .find('h2 > span')
                .remove();
            //adjust the editor's height
            jQuery(wym._box).find(wym._options.iframeSelector)
                .css('height', '550px');
        }
    });
</script>