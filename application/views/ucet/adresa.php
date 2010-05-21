<form action="<?= url::site('ucet/saveAddress')?>" method="post" id="address-form" class="big" >
    <fieldset id="adresa">
        <fieldset>
            <legend><?= Kohana::lang('user.firma')?></legend>
            <div>
                <label for="company" class="float"><?= Kohana::lang('user.company') ?></label>
                <input type="text" name="company" id="company" value="<?= $company?>" />
            </div>
            
            <div>
                <label for="ico" class="float"><?= Kohana::lang('user.ico') ?></label>
                <input type="text" name="ico" id="ico" value="<?= $dico?>" />
            </div>

            <div>
                <label for="dico" class="float"><?= Kohana::lang('user.dico') ?></label>
                <input type="text" name="dico" id="dico" value="<?= $ico?>" />
            </div>                       
        </fieldset>
        <fieldset>
            <legend><?= Kohana::lang('user.billing-address')?></legend>
            <div class="required">
                <label for="name" class="float"><?= Kohana::lang('user.name')?>*</label>
                <input type="text" name="name" required="required" id="name" value="<?= $name?>" />
            </div>

            <div>
                <label for="address_1" class="float"><?= Kohana::lang('user.address_1') ?>*</label>
                <input type="text" name="address_1" required="required" id="address_1" value="<?= $address_1?>" />

            </div>

            <div>
                <label for="city" class="float"><?= Kohana::lang('user.city') ?>*</label>
                <input type="text" name="city" id="city" required="required" value="<?= $city?>" />

            </div>

            <div>
                <label for="zip" class="float"><?= Kohana::lang('user.zip') ?>*</label>
                <input type="text" name="zip" id="zip" value="<?=$zip?>" required="required" min="5"/>

            </div>
            <div>
                <label for="country" class="float"><?= Kohana::lang('user.country') ?></label>
                <input type="text" name="country" id="country" value="Česká republika"/>
            </div>
            <input type="hidden" name="user_info_id" value="<?=$user_info_id?>" />
            
        </fieldset>
        <input type="submit" value="<?= Kohana::lang('main.save')?>"
    </fieldset>
</form>

<script type="text/javascript">
    $('#address-form').validator();
</script>