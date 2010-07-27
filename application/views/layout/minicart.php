<?php $sums = Basket_Model::sums() ?>
<div id="minicart">
    <div><strong><?= Kohana::lang('basket.total') ?></strong> : <?= sprintf('%.1f0',$sums['sum']) ?> (<?= $sums['count'] ?> <?= Kohana::lang('basket.items')?>)</div>
    <div>
        <a href="<?= url::site('pokladna') ?>"><?= Kohana::lang('basket.title') ?>/ <?= Kohana::lang('pokladna.title')?></a>
    </div>
</div>


