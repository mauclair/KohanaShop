<tr <?= text::alternate('', 'class="even"') ?>>
    <td><a href="<?= url::site('administrace/adminOrderStatus/edit/'.$order_status_code)?>"><?= $order_status_code?></a></td>
    <td><?= $order_status_name?></td>
    <td></td>
</tr>