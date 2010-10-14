<tr <?= text::alternate('','class="even"');?>>
    <td>
        <a href="<?= url::site('administrace/adminOrders/detail/'.$order_number)?>"><?= $order_number ?></a>
    </td>
    <td><?= date(Options_Model::ret('date-format'),$cdate)?>
        <? ($cdate!=$mdate) ? '<br /><small>'.date(Options_Model::ret('date-format'),$mdate).'</small>' : ''?>
    </td>
    <td>
        <div class="float-right small"><?= $user_email?><br/><?= $phone_1?></div>
        <?= $name ?>
    </td>
    <td>
        <?= View::factory('admin/orders/status')->set('order_status',$order_status ) ?>
    </td>
    <td>
        <?= format::prize($order_subtotal + $order_shipping) ?>
    </td>
    <td>
        CONTROLS
    </td>
</tr>