<form method="post" action="<?=url::site('basket/add')?>">
<div>
    <input type="hidden" value="<?=$product_id?>" name="product_id"/>
    <input type="text" value="1" name="quantity" maxlength="4" size="2"/>ks
    <a class="nonHover" title="<?= Kohana::lang('main.order')?>" onclick="$(this).parents('form').submit();return(false);" href=".">
        <img alt="Objednat" src="./img4/add_to_cart.png"/>
    </a>
</div>
</form>