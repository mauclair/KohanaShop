<h1><?= Kohana::lang('clanky.title')?></h1>
<? foreach($clanky as $c):?>
<div class="clanek">
    <h2><a href="<?= url::site('clanky/'.$c->clanky_url)?>"><?= $c->title?></a></h2>
    <div><p><?= text::limit_chars( strip_tags($c->body),255)?></p></div>
<div class="info small" ><?= Kohana::lang('clanky.cteno')?>: <?= $c->cteno?>x <?= Kohana::lang('clanky.cdate')?>: <?= date('d.m.Y',$c->cdate)?></div>
</div>
<? endforeach;?>