<form action="<?= url::site('pokladna/ulozAdresy')?>" method="post">
    <div>
        <h3><?= Kohana::lang('user.kontaktni-info')?></h3>

        <label for="email" ><?= Kohana::lang('user.email')?>*</label>
        <input type="text" name="email" id="email" value="<?= $email ?>"  class="required"/>

        <label for="phone" ><?= Kohana::lang('user.phone') ?>*</label>
        <input type="text" name="phone_1" id="phone_1" value="<?= $phone_1 ?>" class="required"/>
    </div>
    <div class="">

        <div>
            <h2><?= Kohana::lang('pokladna.billing-address')?></h2>
            <?           
                echo View::factory('pokladna/address_form')->set($billing_address)->set('prefix','');
            ?>
        </div>
        <div>
            <h2 class="toggler"><?= Kohana::lang('user.shipping-address')?></h2>
            <? $adresses  = array('-1'=>Kohana::lang('pokladna.same-as-billing'),'0'=>Kohana::lang('pokladna.new-address'));
            foreach($addresses as $a) {
                $adresses[$a->user_info_id] = $a->name;
            }?>
            <?= form::dropdown('address_selector',$adresses)?>
            <div id="shipping_address_container">
            </div>
        </div>

    </div>

    <div class="center">
        <input type="submit" value="<?= Kohana::lang('pokladna.rekapitulace') ?>" />
    </div>

</form>

<script type="text/javascript">
    $(function(){
        $('#address_selector').change(function(){
            $('#shipping_address_container').load('pokladna/shipAddressForm', {user_info_id : $(this).val()});
        });
    });
</script>