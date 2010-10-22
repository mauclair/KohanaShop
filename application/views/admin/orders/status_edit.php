<form action="<?= url::site('administrace/adminOrderStatus/update')?>" method="post">
    <div>
        <label for="order_status_code"><?= Kohana::lang('order_status.order_status_code') ?></label>
        <input type="text" id="order_status_code" name="order_status_code" value="<?= $order_status_code?>" />
        <label for="order_status_name"><?= Kohana::lang('order_status.order_status_name') ?></label>
        <input type="text" id="order_status_name" name="order_status_name" value="<?= $order_status_name?>" />
        
        <label for="send_email"><?= Kohana::lang('order_status.send_email') ?></label>
        <input type="checkbox" id="send_email" name="send_email" value="1" <?= $send_email== 1 ? 'checked="checked"' : '' ?> /><br />

        <label for="append_order"><?= Kohana::lang('order_status.append_order') ?></label>
        <input type="checkbox" id="append_order" name="append_order" value="1" <?= $append_order== 1 ? 'checked="checked"' : '' ?> /><br />

        <input type="hidden" name="order_status_id" value="<?= $order_status_id?>" />

        <label for="order_status_mail"><?= Kohana::lang('order_status.order_status_mail') ?></label><br />
        <textarea id="order_status_mail" name="order_status_mail" cols="40" rows="20"><?= $order_status_mail?></textarea><br />

        <input type="submit" value="<?= Kohana::lang('main.save') ?>" class="button button-save" id="submit"/>
    </div>
</form>

<script type="text/javascript" src="scripts/wymeditor/jquery.wymeditor.pack.js"></script>
<script type="text/javascript">
    $(function(){
        $('#order_status_mail').wymeditor({
            lang :  '<?= Session::instance()->get('lang','cs')?>',
            updateSelector: '#submit',
            updateEvent : 'click'
        });

    });
</script>