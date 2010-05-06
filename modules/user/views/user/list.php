<div class="right">
    <a href="<?= url::site('user/newUser')?>"><img src="img/add_48.png" alt="<?= Kohana::lang('main.add')?>" title="<?= Kohana::lang('main.add')?>" /></a>
</div>
<h1><?= Kohana::lang('user.title')?></h1>

<table>
    <tr>
        <th><?= Kohana::lang('user.name')?></th>
        <th></th>
    </tr>
<?foreach ($users as $u):?>
    <tr>
        <td><a href="<?= url::site('user/edit/'.$u->user_id)?>" class="icon-edit-right"><?= $u->name?></a></td>
        <td>
            <a href="<?= url::site('user/edit/'.$u->user_id)?>" class="button icon-edit"><?= Kohana::lang('main.edit')?></a>
            <a href="<?= url::site('user/delete/'.$u->user_id)?>" class="button icon-delete confirm"><?= Kohana::lang('main.delete')?></a>
        </td>
    </tr>
<?endforeach;?>
</table>
