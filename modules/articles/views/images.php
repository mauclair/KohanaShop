<?php
  //echo html::script(array('js/prototype.js','js/scriptaculous.js?load=effects,builder','js/lightbox.js'));

?>
<div class="galleryWrapper">
<?php
  foreach($data as $r){
  	$c  = html::div($r->image_title,array('class'=>'label'));
	$img = html::image(array('title'=>$r->image_title,'alt'=>$r->image_title,'src'=>$r->directory.'/small/'.$r->filename));
	$c = html::file_anchor($r->directory.'/'.$r->filename,$img,array('class'=>'lightbox'));
	if($this->users->isAdmin()){
		$ad = html::anchor('gallery/editImage/'.$r->gallery_images_id,Kohana::lang('main.edit'));
		$c .= html::div($ad);
	}

	echo html::div($c,array('class'=>'galleryItem'));
  }
?>
</div>
<div class="galleryCleaner">&nbsp;</div>