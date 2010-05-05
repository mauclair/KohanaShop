<ul id="categories">
<?foreach($categories as $category):?>
    <li><a href="<?=url::site('kategorie/'.$category['category_url'])?>"><?= $category['category_name']?> [<?=$category['product_count']?>]</a></li>
<?endforeach;?>
</ul>