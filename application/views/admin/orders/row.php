<tr>
    <td>
        <?= $order_number ?>
    </td>
    <td><?= date(Options_Model::ret('date-format'),$cdate)?>
        <? ($cdate!=$mdate) ? '<br /><small>'.date(Options_Model::ret('date-format'),$mdate).'</small>' : ''?>
    </td>
    <td>
        <?= $name ?>
    </td>
    <td>
        <?= $order_status ?>
    </td>
    <td>
        <?= format::prize($order_subtotal + $order_shipping) ?>
    </td>
    <td>
        CONTROLS
    </td>
</tr>