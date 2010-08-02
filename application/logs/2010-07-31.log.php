<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-07-31 11:15:42 +02:00 --- error: SELECT * FROM options   WHERE (`key` = 'site-name')    
2010-07-31 11:15:42 +02:00 --- error: SELECT * FROM options   WHERE (`key` = 'site-name' AND `key` = 'keywords')    
2010-07-31 11:15:42 +02:00 --- error: SELECT * FROM options   WHERE (`key` = 'site-name' AND `key` = 'keywords' AND `key` = 'description')    
2010-07-31 11:15:43 +02:00 --- error: Uncaught PHP Error: array_intersect_key() [<a href='function.array-intersect-key'>function.array-intersect-key</a>]: Argument #1 is not an array in file D:/work/web/kohanaShop/application/models/table.php on line 343
2010-07-31 11:15:43 +02:00 --- error: Uncaught Kohana_404_Exception: The page you requested, favicon.ico, could not be found. in file D:/work/web/kohanaShop/system/core/Kohana.php on line 841
