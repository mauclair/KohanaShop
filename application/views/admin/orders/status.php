<?php
 $statuses = Kohana::config('main.order-status-path');
 foreach ($statuses as $status){?>
<span class="small-button <?=$status==$order_status ? 'button-on' : ''?>" ><?= $status?></span>
 <?}?>
