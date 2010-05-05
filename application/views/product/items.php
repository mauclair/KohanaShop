<? if(!count($products)) return;?>
<div>
    <?foreach($products as $product):?>
        <?=View::factory('product/item_preview')->set((array)$product)->render()?>
    <?endforeach;?>
</div>