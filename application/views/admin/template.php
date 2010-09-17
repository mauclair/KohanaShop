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
    <body>        
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
        <div id="footer" class="clear center">
            <div><?= date('Y',time())?> &copy; bylinářství.cz</div>                    
            <div class="center" ></div>
        </div>
        <script type="text/javascript" src="scripts/administration.js"></script>
     </body>
</html>