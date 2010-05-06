<div class="banner-item">    
<?php
  $f = pathinfo($banner_file);
  $w =  ($banner_width ) ? 'width="'.$banner_width.'"' : '';
  $h =  ($banner_height ) ? 'height="'.$banner_height.'"' : '';  
  if(  strtoupper($f['extension']) == 'SWF'): // got swf... render flash bitch ?>
    <!--[if !IE]> -->
   <object type="application/x-shockwave-flash"  data="<?=$banner_file?>" width="<?=($banner_width==0) ? '' :$banner_width?>" height="<?= ($banner_height==0) ? '' : $banner_height?>">
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
<a href="<?= url::site('banner/click/'.$banner_id)?>"><img src="<?=$banner_file?>" alt="<?=$banner_file?>" <?=$w?> <?=$h?>/></a>
<? endif;?>
</div>