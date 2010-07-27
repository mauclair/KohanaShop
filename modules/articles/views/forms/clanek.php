<?php
echo
	form::open('gallery/uploadImage',array('enctype' => 'multipart/form-data')).
	form::open_fieldset().
	form::legend(Kohana::lang('main.upload')).
	form::label('filename',Kohana::lang('gallery_images.filename')).
	form::upload('filename').
	form::label('image_title',Kohana::lang('gallery_images.image_title')).
	form::input('image_title').
	form::label('gallery_group_id',Kohana::lang('gallery_images.gallery_group_id')).
	form::dropdown('gallery_group_id',$this->groups->getForSelect('gallery_group_id','gallery_title')).
	form::submit('',Kohana::lang('main.upload')).
	form::close_fieldset().
	form::close()

?>