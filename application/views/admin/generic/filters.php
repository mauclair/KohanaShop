<form class="filters" method="post" action="<?= (isset($action) ) ? $action :  url::site('administrace/'.URI::instance()->controller(false).'/setFilter') ?>">
    <?= Kohana::debug();?>
    <div>
        <?= (isset($prepend))? $prepend:'' ?>
        <? foreach($filters as $field=>$filter):?>
            <label for="<?= $field?>"><?= isset($names[$field]) ? $names[$field] : $field?></label>
            <?= form::dropdown($field, $filters[$field], (isset($values[$field]))?$values[$field]:null)?>
        <? endforeach;?>
            <?= (isset($append))? $append:'' ?>
            <input type="submit" value="<?= Kohana::lang('main.filter')?>" />
    </div>
</form>