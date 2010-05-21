<table>
    <tr>
        <th><?= Kohana::lang('user_info.name')?></th>
        <th><?= Kohana::lang('user_info.company')?></th>
        <th><?= Kohana::lang('user_info.address')?></th>
        <th><?= Kohana::lang('user_info.city')?></th>
        <th></th>
    </tr>
<?foreach($adresy as $adresa):?>
    <tr <?=text::alternate('','class="even"')?>>
        <td><?= $adresa->name?></td>
        <td><?= $adresa->company?></td>
        <td><?= $adresa->address_1?></td>
        <td><?= $adresa->city?></td>
        <td><a class="edit-address" href="<?= url::site('ucet/uprava_adresy/'.$adresa->user_info_id)?>"><?= Kohana::lang('main.edit')?></a></td>
    </tr>
<?endforeach;?>
</table>

<script type="text/javascript" >
    $(function(){
        $('a.edit-address').overlay({
            mask : '#eee',
            target: '#overlay',
            speed : 100,
            onBeforeLoad: function(){
                $("#overlay").load(this.getTrigger().attr('href'));
            }
        });
    });
</script>