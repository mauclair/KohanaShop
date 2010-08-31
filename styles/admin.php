<?php
include '../lib/cssmin.php';
ob_start ("ob_gzhandler");
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 10 * 24 * 60 * 60 ;
$ExpStr = "Expires: " .
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);

ob_start();
  echo '@CHARSET "UTF-8";';

  include('reset.css');
  include('text.css');
  /*include('basket.css');
  include('forms.css');
  include('product4.css');
  include('left_menu.css');

  include('classes.css');
  include('poradna.css');
  include('bylinky.css');
  include('caj.css');*/

  include('admin.css');
  include('forms.css');
  include('tabs.css');

 $c = ob_get_clean();

 echo cssmin::minify($c);


ob_end_flush();
?>
