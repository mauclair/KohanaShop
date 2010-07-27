<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?= $title ?> - Bylinářství.cz</title>
        <base href="<?= url::base() ?>" />
        <link href="styles/admin.php" 	rel="stylesheet" type="text/css" media="screen" />
        <link href="styles/print.css" 	rel="stylesheet" type="text/css" media="print" 	/>


        <meta http-equiv="content-language" content="cs" />
        <meta name="copyright" content="©2008-<?=date('Y')?> SNB@Bylinarstvi.cz, e-mail: snoblucha-AT-email.cz" />
        <meta name="keywords" content="bylinky,bylinářství,bylinkářství,prodej,zdravý,styl,léčí,medicína, vitamíny, minerály,poradna" />
        <meta name="description" content="" />
        <meta name="resource-type" content="document" />
        <meta name="author" content="code: Petr Snobl / content: David Karel" />
        <meta name="googlebot" content="nofollow" />
        <meta name="robots" content="nofollow" />

        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link rel="shortcut icon" href="img/favicon.ico" />
        <script src="http://cdn.jquerytools.org/1.2.2/full/jquery.tools.min.js" type="text/javascript"></script>
    </head>
234522
    <body>
        <?= $quickSearch ?>
        <?= $directLogin ?>        
        <div id="header"><a href="<?= url::base() ?>" >TODO> HEADER / go to page ...</a></div>
            <div  id="mainWrapper" >
            <div id="mainCenter" >
                <div id="leftMenu" > <?= $menu ?></div>
                <div id="content">
                    <?= View::factory('errors')->set('errors',Session::instance()->get_once('errors',array())) ?>
                    <?= $content ?>
                </div>

            </div>
        </div>        
        <div id="footer" class="center">
            <div><?= date('Y',time())?> &copy; bylinářství.cz</div>
            <a href="http://www.toplist.cz/" target="_top"><img src="http://toplist.cz/count.asp?id=949419&amp;logo=btn" border="0" alt="TOPlist" width="80" height="15"/></a>

           <?/*<script type="text/javascript">var addthis_pub="4a08501c6a75f26c";</script>
            <a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script><!-- AddThis Button END -->*/?>
            <div class="center" ></div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('.confirm').click(function(){
                    return(confirm($(this).attr('title')));
                });
            });
</script>
     </body>
</html>