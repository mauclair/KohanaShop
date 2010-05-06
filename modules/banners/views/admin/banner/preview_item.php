
<div style="position:relative; width: 100px; height : 100px;"><?php
  $f = pathinfo($banner_file);
  $w =  'width="100"';
  $h =  'height="100"';
  if(  strtoupper($f['extension']) == 'SWF'): // got swf... render flash bitch  ?>
    <!--[if !IE]> -->
   <object type="application/x-shockwave-flash"  data="<?=$banner_file?>" width="<?=$banner_width?>" height="<?=$banner_height?>">
<!-- <![endif]-->

<!--[if IE]>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
  width="<?=$banner_width?>" height="<?=$banner_height?>">
  <param name="movie" value="<?=$banner_file?>" />
<!--><!--dgx-->
  <param name="loop" value="true" />
  <param name="menu" value="false" />
  <p><?=$banner_file?></p>
</object>
<!-- <![endif]-->

<? else :?>
<a href="<?= url::site('adminBanner/edit/'.$banner_id)?>"><img src="<?=$banner_file?>" alt="<?=$banner_file?>" <?=$w?> <?=$h?>/></a>
<? endif;?>
</div>
<a class="icon-edit-right small" href="<?= url::site('adminBanner/edit/'.$banner_id)?>"><span class="small"><?= $banner_url?></span></a>
