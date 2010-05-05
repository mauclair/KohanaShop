<div class="menuWrapper">
    <strong> <?= Kohana::lang('main.navigation') ?> </strong>
    <ul>
        <?if (is::logged()) :?>
        <li><a href="<?= url::site('account')?>"   ><?= Kohana::lang('user.account') ?></a></li>
        <?endif;?>
        <li>
<? if (is::logged()) : ?>
            <a href="<?= url::site('user/logout')?>"><?= Kohana::lang('user.logout')?></a>
<? else : ?>
            <a  href="<?= url::site('user/register') ?>"><?= Kohana::lang('user.register')?></a>
<?endif;?>
        </li>        
        <li><a href="<?= url::site('basket')?>"><?= Kohana::lang('pokladna.title')?></a></li>                
        <li><a href="<?= url::site('shop/caj')?>"><?= Kohana::lang('shop.caj')?></a></li>
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