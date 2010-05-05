<a href="<?= url::site('adminUser/newUser')?>"><img src="imgs/icons/add_16.png" alt="<?= Kohana::lang('main.add')?>" title="<?= Kohana::lang('main.add')?>" /></a>
<table>
    <tr>
        <th colspan="4">
            <form action="<?= url::site('adminUser/setFilter')?>" method="post">
                <div>
                    <label for="level"><?= Kohana::lang('user.level')?></label>                    
                    <?= form::dropdown('level',array(''=>'','255'=>Kohana::lang('user.levels.255'),'0'=>Kohana::lang('user.levels.0')),$level)?>
                    <input type="submit" value="<?= Kohana::lang('main.filter')?>" />
                </div>
            </form>
        </th>
    </tr>
    <tr>
        <th><a href="<?= url::site('admin/sort/name')?>"><?= Kohana::lang('user.name')?></a></th>
        <th><a href="<?= url::site('admin/sort/email')?>"><?= Kohana::lang('user.email')?></a></th>
        <th><a href="<?= url::site('admin/sort/level')?>"><?= Kohana::lang('user.level')?></a></th>
        <th></th>
    </tr>
    <? foreach($users as $u):?>
    <tr <?= text::alternate('','class="even"')?>>
        <td><a href="<?= url::site('adminUser/edit/'.$u->user_id)?>"><?= $u->name?></a></td>
        <td><?= $u->email?></td>
        <td><?= Kohana::lang('user.levels.'.$u->level)?></td>
        <td>
            <a class="confirm" href="<?= url::site('adminUser/delete/'.$u->user_id)?>" title="<?= Kohana::lang('main.delete')?>: <?= $u->name?> ?"><img src="imgs/icons/cancel_16.png"  alt="<?= Kohana::lang('main.delete')?>" /></a>
            <a href="<?= url::site('adminUser/edit/'.$u->user_id)?>"><img src="imgs/icons/pencil_16.png"  alt="<?= Kohana::lang('main.edit')?>" /></a>
        </td>    
    </tr>
    <?endforeach;?>
</table>