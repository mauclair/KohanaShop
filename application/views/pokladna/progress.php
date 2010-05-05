<?
  $items = 5;
  $classes = array();
  $pos = $pos-1;
  for($i=0; $i<$items;$i++) $classes[] = ($i<$pos) ? 'active' : ( ($i == $pos) ? 'current' : '');
?>
<div class="pokladna-progress">
    <div class="<?= $classes[0]?>">
        <strong>1</strong>
        <a href="<?= url::site('pokladna')?>"><?= Kohana::lang('basket.title')?></a>
    </div>
    <div class="<?= $classes[1]?>">
        <strong>2</strong>
        <a href="<?= url::site('pokladna/doprava')?>"><?= Kohana::lang('pokladna.doprava-a-platba')?></a>
    </div>
    <div class="<?= $classes[2]?>">
        <strong>3</strong>
        <a href="<?= url::site('pokladna/adresa')?>"><?= Kohana::lang('pokladna.adresa')?></a>
    </div>
    <div class="<?= $classes[3]?>">
        <strong>4</strong>
        <a href="<?= url::site('pokladna/rekapitulace')?>"><?= Kohana::lang('pokladna.rekapitulace')?></a>
    </div>
    <div class="<?= $classes[4]?>">
        <strong>5</strong>
        <a href="<?= url::site('pokladna/dokoncit')?>"><?= Kohana::lang('pokladna.dokoncit')?></a>
    </div>
</div>