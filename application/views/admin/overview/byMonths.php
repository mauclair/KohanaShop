<?= $chart ?>
<?
    $months = Kohana::lang('main.months');
?>
<table bgcolor="#cccccc" width="100%" border="0" cellspacing="0"
       cellpadding="1">
    <tr>
        <th>Datum</th>
        <th>Objednávek</th>
        <th>Prodáno ks</th>

        <th>Odesláno/ Poštovné<br /> <small>čistý příjem</small></th>
        <th>Potvrzeno</th>
        <th>Nepotvrzeno</th>
        <th>Zrušeno</th>
        <th>Vráceno</th>
        <th>Objednáno</th>
    </tr>
    <?foreach($data as $row):?>
    <tr <?= text::alternate('','class="even"')?>>
        <td><?= $months[(int)substr($row->month , 4)-1]. ' / ' .substr($row->month, 0,4)?> </td>
            <td><?= $row->number_of_orders ?></td>
            <td><?= '_products saled_'?></td>

            <td><?= $row->revenue_S ?> / 
                <?= $row->shipped_shipping ?> <br />
                <small><?= ( $row->revenue_S - $row->shipped_shipping) ?> </small></td>
            <td><?= $row->revenue_C ?></td>
            <td><?= $row->revenue_P ?></td>
            <td><?= $row->revenue_X ?></td>
            <td><?= $row->revenue_V ?></td>
            <td class="center"><?= $row->revenue ?></td>
        </tr>
    <?endforeach;?>
</table>
