<tr <?= text::alternate('','class="even"')?>>
            <? foreach($fields as $field=>$fieldname): ?>
            <td><?= $$field; ?></td>
            <? endforeach; ?>
            <td>
                <a class="small-button confirm" href="<?= url::site('administrace/'.URI::instance()->segment(2).'/delete/'.${$this->model->id})?>"><?= Kohana::lang('main.delete') ?></a>
                <a class="small-button" href="<?= url::site('administrace/'.URI::instance()->segment(2).'/edit/'.${$this->model->id})?>"><?= Kohana::lang('main.edit') ?></a>
            </td>
</tr>