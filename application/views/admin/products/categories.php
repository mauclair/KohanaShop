<div id="categories-list">
<?php foreach($categories as $category):?>
    <div id="category_id-<?$category->category_id?>"><?= $category->category_name?></div>
<?  endforeach;?>
</div>