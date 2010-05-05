<form action="<?= url::site('uzivatel/novy')?>" method="post" id="Register" class="big" id="Register">
    <fieldset id="register">
        <fieldset>
            <legend><?= Kohana::lang('user.login-info')?></legend>
            <input type="hidden" name="address_type" value="BT" />
            <div class="required">
                <label for="login" class="float"><?= Kohana::lang('user.username') ?>*</label>
                <input type="text" name="username" value="<?= $username ?>" id="login" class="required"/>
            </div>
            <div id="loginMessage" style="font-size:small;" class="right"></div>

            <div class="required">
                <label for="password" class="float"><?= Kohana::lang('user.password')?>*</label>
                <input type="password" name="password" id="password" value="" class="required"/>
            </div>
            <div class="required">
                <label for="password_again" class="float"><?= Kohana::lang('user.retype-password') ?></label>
                <input type="password" name="password_again" id="password_again" value="" class="required" />
            </div>
            <div id="passwordMessage" style="font-size:small;" class="right"></div>
        </fieldset>
        <fieldset>
            <legend><?= Kohana::lang('user.firma')?></legend>
            <div>
                <label for="company" class="float"><?= Kohana::lang('user.company') ?></label>
                <input type="text" name="company" id="company" value="<?= $company ?>" />
            </div>

            <div>
                <label for="ico" class="float"><?= Kohana::lang('user.ico') ?></label>
                <input type="text" name="ico" id="ico" value="<?= $ico ?>" />
            </div>

            <div>
                <label for="dico" class="float"><?= Kohana::lang('user.dico') ?></label>
                <input type="text" name="dico" id="dico" value="<?= $dico ?>" />
            </div>

            <div>&nbsp;</div>
            <div class="center">
                <label for="chceVelkoobchod" style="display:inline"><?=Kohana::lang('user.chceVelkoobchod') ?></label>
                <input type="checkbox" name="chceVelkoobchod" id="chceVelkoobchod" value="Y" <?=($chceVelkoobchod=='Y')? 'checked="checked"':'' ?> />
            </div>

        </fieldset>
        <fieldset>
            <legend><?= Kohana::lang('user.kontaktni-info')?></legend>
            <div class="required">
                <label for="email" class="float"><?= Kohana::lang('user.email')?>*</label>
                <input type="text" name="email" id="email" value="<?= $email ?>"  class="required"/>
            </div>

            <div class="required">
                <label for="phone_1" class="float"><?= Kohana::lang('user.phone') ?>*</label>
                <input type="text" name="phone_1" id="phone_1" value="<?= $phone_1 ?>" class="required"/>
            </div>

        </fieldset>

        <fieldset>
            <legend><?= Kohana::lang('user.billing-address')?></legend>
            <div class="required">
                <label for="name" class="float"><?= Kohana::lang('user.name')?>*</label>
                <input type="text" name="name" class="required" id="first_name" value="<?= $name ?>" />
            </div>

            <div class="required">
                <label for="address_1" class="float"><?= Kohana::lang('user.address_1') ?>*</label>
                <input type="text" name="address_1"	id="address_1" value="<?= $address_1 ?>" />

            </div>

            <div class="required">
                <label for="city" class="float"><?= Kohana::lang('user.city') ?>*</label>
                <input type="text" name="city" id="city" value="<?= $city ?>"  class="required"/>

            </div>

            <div class="required">
                <label for="zip" class="float"><?= Kohana::lang('user.zip') ?>*</label>
                <input type="text" name="zip" id="zip" value="<?= $zip ?>"  class="required"/>

            </div>

            <div>
                <label for="country" class="float"><?= Kohana::lang('user.country') ?></label>
                <input type="text" name="country" id="country" value="Česká republika"/>
            </div>
        </fieldset>

        <div class="center">
            <label for="user_advertisement" style="display:inline"> <?= Kohana::lang('user.send-emails') ?></label>
            <input type="checkbox" name="user_advertisement" id="user_advertisement" checked="checked" value="Y" <?=($user_advertisement=='Y')? 'checked="checked"':'' ?> />
        </div>
        <div class="center">
            <input type="submit" name="Register" value="<?= Kohana::lang('user.register') ?>" />
        </div>
    </fieldset>
</form>