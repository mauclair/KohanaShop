<?= $chart ?>
<table bgcolor="#cccccc" width="100%" border="0" cellspacing="0"
       cellpadding="1">
    <tr>
        <td><b>Datum</b></td>
        <td><b>Objednávek</b></td>
        <td><b>Prodáno ks</b></td>

        <td><b>Odesláno</b>/ Poštovné<br /> <small>čistý příjem</small></td>
        <td><b>Potvrzeno</b></td>
        <td><b>Nepotvrzeno</b></td>
        <td><b>Zrušeno</b></td>
        <td><b>Vráceno</b></td>
        <td>Objednáno</td>
    </tr>
    <?foreach($data as $row):?>
    <tr <?= text::alternate('','class="even"')?>>
            <td><?= $row->month ?> </td>
            <td><?= $row->number_of_orders ?></td>
            <td><?= '_products saled_'?></td>

            <td><b><?= $row->revenue_S ?></b> / 
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
