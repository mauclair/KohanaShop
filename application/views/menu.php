<div id="menu">
    <ul>
        <li><a href="<?=url::site('catalog/cd')?>"><?= Kohana::lang('cd.title')?></a></li>
        <li><a href="<?=url::site('catalog/video')?>"><?= Kohana::lang('video.title')?></a></li>
        <li><a href="<?=url::site('tags')?>"><?=Kohana::lang('tag.title');?></a></li>
        <li><a href="<?=url::site('catalog/search')?>"><?=Kohana::lang('main.search');?></a></li>        
        <li><a href="<?=url::site('catalog/switchLang/de')?>">de</a> / <a href="<?=url::site('catalog/switchLang/cz')?>">cz</a> / <a href="<?=url::site('catalog/switchLang/en')?>">en</a></li>
        <li><a href="<?=url::site('admin')?>"><?=Kohana::lang('admin.title');?></a></li>
        <?/*<li><a href="<?=url::site('container')?>"><?=Kohana::lang('container.title');?></a></li>*/?>
        <li><?=Kohana::lang('main.dir_count')?>: <?=$dir_count?></li>
        <li><?=Kohana::lang('main.img_count')?>: <?=$img_count?></li>
        <li><?=Kohana::lang('main.vid_count')?>: <?=$vid_count?></li>
        <li><?= Kohana::lang('main.free')?>: <?=format::size(@disk_free_space(Kohana::config('catalogue.directory')))?></li>
    </ul>
</div>
<div class="clear"></div>