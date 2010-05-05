<form class="" method="post" action="<?= url::site('pokladna/ulozDopravu')?>">
    <div>
<? foreach ($shipping as $s) :?>        
        <input type="radio" id="shipping_id_<?=$s->shipping_id?>" 
               name="shipping_id" value="<?= $s->shipping_id?>"
               <?= ($this->session->get('pokladna.doprava.shipping_id')==$s->shipping_id) ? 'checked="checked"': ''?>
        />
        <label for="shipping_id_<?=$s->shipping_id?>" ><?= $s->shipping_name?> <strong><?= $s->shipping_cost?></strong></label>
        <br />
<?endforeach;?>
        <input type="submit" value="<?= Kohana::lang('pokladna.adresa')?>"/>
    </div>
</form>