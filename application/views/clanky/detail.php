<h1><?=$title?></h1>
<div class="clanky-info small"><?= Kohana::lang('clanky.cteno')?>: <?=$cteno?>x <?= Kohana::lang('clanky.cdate')?>: <?=date(Kohana::config('main.date-format',$cdate))?></div>
<div class="clanek-body">
    <?= $body?>
</div>
<?if($products):?>
<h2><?= Kohana::lang('clanky.products')?></h2>
<div id="clanky-products"><?= $products?></div>
<?endif;?>