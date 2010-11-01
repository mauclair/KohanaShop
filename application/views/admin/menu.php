<ul id="adminMenu">
    <li><a <?= is::href('administrace/adminProducts')?> ><?= Kohana::lang('product.title')?></a></li>
    
    <li><a <?= is::href('administrace/adminOrders')?> ><?= Kohana::lang('order.title')?></a></li>
    <li>
        <ul>
            <li><a <?= is::href('administrace/adminOrderStatus')?>><?= Kohana::lang('order_status.title')?></a></li>
        </ul>
    </li>
    
    <li><a <?= is::href('administrace/adminShipping')?>><?= Kohana::lang('shipping.title')?></a></li>
    
    <li><a <?= is::href('administrace/adminOverview')?> ><?= Kohana::lang('overview.title')?></a></li>
</ul>