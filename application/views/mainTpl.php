<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? // $seo = meta($page,$product_id, $category_id, $id ); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?= $title ?> - Bylinářství.cz</title>
        <base href="<?= url::base() ?>" />
        <link href="styles/style.php" 	rel="stylesheet" type="text/css" media="screen" />
        <link href="styles/print.css" 	rel="stylesheet" type="text/css" media="print" 	/>


        <link rel="alternate" title="www.bylinarstvi.cz : <?= Kohana::lang('rss.produts') ?>" href="http://www.bylinarstvi.cz/?page=shop/rss&amp;ajax" type="application/rss+xml" />
        <link rel="alternate" title="www.bylinarstvi.cz : <?= Kohana::lang('rss.featured') ?>" href="http://www.bylinarstvi.cz/?page=shop/rss&amp;ajax&amp;typ=featured" type="application/rss+xml" />
        <link rel="alternate" title="www.bylinarstvi.cz : <?= Kohana::lang('rss.discounted') ?>" href="http://www.bylinarstvi.cz/?page=shop/rss&amp;ajax&amp;typ=discounted" type="application/rss+xml" />
        <link rel="alternate" title="www.bylinarstvi.cz : <?= Kohana::lang('clanky.title') ?>" href="http://www.bylinarstvi.cz/?page=shop/rss&amp;ajax&amp;typ=clanky" type="application/rss+xml" />
        <link rel="alternate" title="www.bylinarstvi.cz : <?= Kohana::lang('poradna.title') ?>" href="http://www.bylinarstvi.cz/?page=shop/rssPoradna&amp;ajax" type="application/rss+xml" />

        <meta http-equiv="content-language" content="cs" />
        <meta name="copyright" content="©2008-<?=date('Y')?> SNB@Bylinarstvi.cz, e-mail: snoblucha-AT-email.cz" />
        <meta name="keywords" content="bylinky,bylinářství,bylinkářství,prodej,zdravý,styl,léčí,medicína, vitamíny, minerály,poradna" />
        <meta name="description" content="" />
        <meta name="resource-type" content="document" />
        <meta name="author" content="code: Petr Snobl / content: David Karel" />
        <meta name="googlebot" content="index, follow, snippet, archive" />
        <meta name="robots" content="all, follow" />

        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link rel="shortcut icon" href="img/favicon.ico" />
        <script src="http://www.google.com/jsapi" type="text/javascript"></script>
        <script type="text/javascript">
            // Load jQuery
              google.load("jquery", "1");
//              google.load("jqueryui", "1");
        </script>


    </head>

    <body>
        <?= $quickSearch ?>
        <?= $directLogin ?>        
        <div  id="mainWrapper" >
            <div id="mainCenter" >
                <div id="leftMenu" > <?= $leftMenu ?></div>
                <div id="content">
                    <?= View::factory('errors')->set('errors',Session::instance()->get_once('errors',array())) ?>
                    <?= $content ?>
                </div>

            </div>
        </div>
        <div id="topMenu">
            <?= $topMenu?>
        </div>
        <div id="header"><a href="<?= url::base() ?>" ></a></div>
        <?= $loggedInfo ?>
        <?= $minicart ?>
        <?= $langSwitch ?>
        <?= $currencySwitch ?>
        <?= $leftMenuBar ?>
        <?= $headerLinks ?>

        <div id="footer" class="center">
            <div><?= date('Y',time())?> &copy; bylinářství.cz</div>
            <a href="http://www.toplist.cz/" target="_top"><img src="http://toplist.cz/count.asp?id=949419&amp;logo=btn" border="0" alt="TOPlist" width="80" height="15"/></a>

           <?/*<script type="text/javascript">var addthis_pub="4a08501c6a75f26c";</script>
            <a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script><!-- AddThis Button END -->*/?>
            <div class="center" ></div>
        </div>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            var pageTracker = _gat._getTracker("UA-5111359-1");
            pageTracker._initData();
            pageTracker._trackPageview();
        </script>

        
    </body>
</html>