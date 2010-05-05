<form action="<?= url::site('uzivatel/login')?>" method="post" id="Login" class="big">
        <fieldset>

            <p class="center"><?= Kohana::lang('user.login-existing-customer') ?></p>
            <div>
                <label for="llogin" class="float"><?=Kohana::lang('user.username')?></label>
                <input type="text" name="username" id="llogin" value="" />
            </div>
            <div>
                <label for="lpwd" class="float"><?=Kohana::lang('user.password')?></label>
                <input type="password" name="password" id="lpwd" />
            </div>
            <div class="center"><input type="submit" name="Login" value="<?= Kohana::lang('user.login')?>" /></div>

            <p class="center small"><a href="<?=  url::site('user/lostPassword')?>"><?= Kohana::lang('user.lost-password')?></a></p>
        </fieldset>
    </form>