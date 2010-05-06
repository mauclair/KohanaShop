<?
    $not_set = '<img src="img/circle_green.png"  alt="Not set" title="Not set"/>'
?>
<div class="right">
    <a href="<?= url::site('adminBanner/newBanner')?>"><img src="img/add_48.png" alt="<?= Kohana::lang('main.add')?>" title="<?= Kohana::lang('main.add')?>" /></a>
</div>
<h1><?= Kohana::lang('banners.title')?></h1>
<table>
    <tr>
        <th><?= Kohana::lang('main.preview')?></th>
        <th><?= Kohana::lang('banners.clicked')?></th>
        <th><?= Kohana::lang('banners.display_from')?></th>
        <th><?= Kohana::lang('banners.display_to')?></th>
        <th><?= Kohana::lang('banners.display_clicks')?></th>
        <th></th>
    </tr>
<?foreach($banners as $banner):?>
    <tr class="<?= text::alternate('','even')?>">
        <td><div id="ban-<?=$banner->banner_id?>" class="banner-preview"><?=Banner_Model::render($banner->banner_id)?></div></td>
        <td><?=$banner->clicked?></td>
        <td><?=($banner->dfrom != '0.0.0000')? $banner->dfrom : $not_set?></td>
        <td><?=(strcmp($banner->dto,'0.0.0000')!=0)? $banner->dto : $not_set?></td>
        <td><?=($banner->display_clicks==0) ? $not_set : $banner->display_clicks ?></td>
        <td>
           <a class="button icon-edit" href="<?= url::site('adminBanner/edit/'.$banner->banner_id)?>"><?= Kohana::lang('main.edit')?></a>
           <a class="confirm button icon-delete" href="<?= url::site('adminBanner/delete/'.$banner->banner_id)?>"><?= Kohana::lang('main.delete')?></a>
        </td>
    </tr>

<?endforeach;?>
</table>