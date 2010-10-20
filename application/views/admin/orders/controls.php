<div class="order_statuses">
<? foreach($statuses as $status){?>
    <div class="order_status">
        <a class="small-button  <?= $order_status==$status->order_status_code ? 'button-on' : ''?>"
           href="<?= url::site('administrace/adminOrders/changeStatus/'.$order_number.'/'.$status->order_status_code)?>"><?= $status->order_status_name ?></a>
    </div>
<? } ?>
</div>