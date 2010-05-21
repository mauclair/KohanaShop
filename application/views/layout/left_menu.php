<div class="menuWrapper">
    <strong> <?= Kohana::lang('main.navigation') ?> </strong>
    <ul>
<?if (is::logged()) :?>
        <li><a <?= is::href('ucet','ucet/*')?>><?= Kohana::lang('user.account') ?></a></li>
        <li><a href="<?= url::site('uzivatel/logout')?>"><?= Kohana::lang('user.logout')?></a></li>
<? else : ?>
        <li><a <?= is::href('uzivatel/registrovat') ?>><?= Kohana::lang('user.register')?></a></li>
<?endif;?>        
        <li><a <?= is::href('basket')?>><?= Kohana::lang('pokladna.title')?></a></li>
        <li><a <?= is::href('shop/caj')?>><?= Kohana::lang('shop.caj')?></a></li>
    </ul>
</div>
<br />
<div class="menuWrapper">
    <?=$categories?>
</div>
<br />
<br />
<div class="menuWrapper">
    <strong> <?=  Kohana::lang('main.advertisement') ?> </strong>
    <ul>
        <li> <a href="http://www.drkarel.cz"  title="Dr.Karel"><img src="<?= url::base() ?>/reklamy/drkarel_150px.png" alt="Dr.Karel" /></a> </li>
    </ul>
</div>