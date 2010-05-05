<form action="<?= url::site($action)?>" method="post" id="Register" class="big" id="Register">
    <fieldset id="register">
        <fieldset>
            <legend><?= Kohana::lang('user.firma')?></legend>
            <div>
                <label for="company" class="float"><?= Kohana::lang('user.company') ?></label>
                <input type="text" name="company" id="company" value="" />
            </div>

            <div>
                <label for="ico" class="float"><?= Kohana::lang('user.ico') ?></label>
                <input type="text" name="ico" id="ico" value="" />
            </div>

            <div>
                <label for="dico" class="float"><?= Kohana::lang('user.dico') ?></label>
                <input type="text" name="dico" id="dico" value="" />
            </div>

            <div>&nbsp;</div>
            <div class="center">
                <label for="chceVelkoobchod" style="display:inline"><?=Kohana::lang('user.chceVelkoobchod') ?></label>
                <input type="checkbox" name="chceVelkoobchod" id="chceVelkoobchod" value="Y"  />
            </div>

        </fieldset>
        <fieldset>
            <legend><?= Kohana::lang('user.kontaktni-info')?></legend>
            <div class="required">
                <label for="email" class="float"><?= Kohana::lang('user.email')?>*</label>
                <input type="text" name="user_email" id="email"   class="required"/>
            </div>

            <div class="required">
                <label for="phone_1" class="float"><?= Kohana::lang('user.phone') ?>*</label>
                <input type="text" name="phone_1" id="phone_1"  class="required"/>
            </div>

        </fieldset>

        <fieldset>
            <legend><?= Kohana::lang('user.billing-address')?></legend>
            <div class="required">
                <label for="name" class="float"><?= Kohana::lang('user.name')?>*</label>
                <input type="text" name="name" class="required" id="first_name" value="" />
            </div>

            <div class="required">
                <label for="address_1" class="float"><?= Kohana::lang('user.address_1') ?>*</label>
                <input type="text" name="address_1"	id="address_1" value="" />

            </div>

            <div class="required">
                <label for="city" class="float"><?= Kohana::lang('user.city') ?>*</label>
                <input type="text" name="city" id="city" value=""  class="required"/>

            </div>

            <div class="required">
                <label for="zip" class="float"><?= Kohana::lang('user.zip') ?>*</label>
                <input type="text" name="zip" id="zip" value=""  class="required"/>

            </div>

            <div>
                <label for="country" class="float"><?= Kohana::lang('user.country') ?></label>
                <input type="text" name="country" id="country" value="Česká republika"/>
            </div>
        </fieldset>
        <div class="center">
            <input type="submit" name="Register" value="<?= Kohana::lang('user.register') ?>" />
        </div>
    </fieldset>
</form>