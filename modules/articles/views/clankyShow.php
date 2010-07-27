<?php
	$data  =(!isset($data)) ? array() : $data;
	echo html::open_table().
		  html::open_tr().
		  	html::th(Kohana::lang('clanky.clanky_title')).
		  	html::th(Kohana::lang('clanky.clanky_group_id')).
		  	html::th(Kohana::lang('clanky.cdate')).
		  	html::th(Kohana::lang('clanky.mdate')).
		  html::close_tr();
		  foreach($data as $r){
		  	echo
		  	  html::open_tr().
		  	  html::td(html::anchor('clanky/edit/'.$r->clanky_id,$r->clanky_title)).
		  	  html::td($r->group_title).
		  	  html::td(date('d.m.y',$r->cdate)).
		  	  html::td(date('d.m.y',$r->mdate)).
		  	  html::close_tr();
		  }
		 echo html::close_table();

?>