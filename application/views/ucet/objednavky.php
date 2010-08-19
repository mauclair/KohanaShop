<table>
    <tr>
        <th><?= Kohana::lang('order.number')?></th>
        <th><?= Kohana::lang('order.cdate')?></th>
        <th><?= Kohana::lang('order.mdate')?></th>
        <th><?= Kohana::lang('order.status')?></th>
        <th><?= Kohana::lang('order.prize')?></th>
        <th></th>
    </tr>
<?foreach($objednavky as $objednavka):?>
    <tr class="status_<?= $objednavka->order_status ?>">
        <td><?=$objednavka->order_number?></td>
        <td><?= date('d.m.Y H:i',$objednavka->cdate) ?></td>
        <td><?= date('d.m.Y H:i',$objednavka->mdate) ?></td>
        <td><?= Kohana::lang('order.status_str.'.$objednavka->order_status)?></td>
        <td><?= $objednavka->order_subtotal + $objednavka->order_shipping_tax ?></td>
        <td><a href="<?= url::site('uzivatel/objednavka/'.$objednavka->order_number)?>"><?= Kohana::lang('main.show')?></a></td>
    </tr>
<?endforeach;?>
</table>