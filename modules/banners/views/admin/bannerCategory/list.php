<div class="right">
    <a href="<?= url::site('adminBannerCategories/newCategory')?>"><img src="img/add_48.png" alt="<?= Kohana::lang('main.add')?>" title="<?= Kohana::lang('main.add')?>" /></a>
</div>
<h1><?= Kohana::lang('bannercategory.title')?></h1>
<table>
    <tr>        
        <th><?= Kohana::lang('bannercategory.bannerCategory_name')?></th>
        <th><?= Kohana::lang('bannercategory.bannerCategory_slots')?></th>
        <th></th>
    </tr>
<?foreach($categories as $cat):?>
    <tr class="<?= text::alternate('','even')?>">        
        <td><a class="icon-edit-right" href="<?= url::site('adminBannerCategories/edit/'.$cat->bannerCategory_id)?>"><?=$cat->bannerCategory_name?></a></td>
        <td><?=($cat->bannerCategory_slots==0) ? Kohana::lang('bannercategory.unlimited') : $cat->bannerCategory_slots?></td>
        <td>
           <a class="button icon-edit" href="<?= url::site('adminBannerCategories/edit/'.$cat->bannerCategory_id)?>"><?= Kohana::lang('main.edit')?></a>
           <a class="confirm button icon-delete" href="<?= url::site('adminBannerCategories/delete/'.$cat->bannerCategory_id)?>"><?= Kohana::lang('main.delete')?></a>
        </td>
    </tr>

<?endforeach;?>
</table>