<h1><?= $product_name ?></h1>

<div id="productInfo">
    <div class="productFullImage">
        <img src="images/product/<?=$product_thumb_image?>" alt="<?=$product_name?>" title="<?= $product_name?>" />
    </div>

    <? if (is::admin()): ?>
    <div><a href="<?= url::site('adminProdukt/edit/'.$product_url)?>"><?= Kohana::lang('main.edit')?></a></div>
    <? endif; ?>

    <table id="productInfoTable">
        <tr><td class="title"><?= Kohana::lang('category.title') ?></td>
            <td><ul>
                    <?foreach($categories as $cat ) :?><li><a href="<?= url::site('kategorie/'.$cat->category_url)?>"><?= $cat->category_name?></a></li><?  endforeach?>
                </ul>
            </td>
        </tr>
        
        <tr>
            <td class="title"><?= Kohana::lang('product.product_code')?></td>
            <td><?= $product_code ?></td>
        </tr>
        <tr>
            <td class="title"><?= Kohana::lang('product.vendor')?> </td>
            <td><a href="<?= url::site('vyrobce/'.$vendor_url)?>"><?= $vendor_name ?></a></td>
        </tr>
        <tr>
            <td class="title"><?= Kohana::lang('indication.title')?> </td>
            <td><?= $indikace  ?></td>
        </tr>
<? if ($product_expiration_date>0) :?>
        <tr>
            <td class="title"><?= Kohana::lang('product.product_expiration')  ?> </td>
            <td><?= date("d.m.Y",$product_expiration_date);  ?></td>
        </tr>
<? endif; ?>
        

<?foreach($atributes as $a) : ?>
        <tr>
            <td class="title"><?=$a->attribute_name ?> </td>
            <td><?=$a->attribute_value ?></td>
        </tr>
<?endforeach; ?>
        <tr>
            <td class="title"><?= Kohana::lang('product.price')?> </td>
            <td class="price">
                <?= View::factory('product/prize')->set('tax',$product_taxes_value)->set('discount',$product_discount_id)->set('prize',$product_price)->render()?>
            </td>
        </tr>
        <tr><td colspan="2" class="form"><?= View::factory('product/form')->set('product_id',$product_id)->render(); ?></td></tr>
    </table>

    <h2><?= Kohana::lang('product.product_desc')?></h2>
    <p><?=$product_desc; ?></p>
    <h2><?= Kohana::lang('product_details.contains') ?></h2>
    <p><?=  $contains; ?></p>
    <h2><?= Kohana::lang('product_details.warning') ?></h2>
    <p><?=  $warning ?></p>
    <h2><?= Kohana::lang('product_details.aplication') ?></h2>
    <p><?= $aplication ?></p>
 

</div>