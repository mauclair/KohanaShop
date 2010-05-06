<form action="<?=url::site('user/loginAction')?>" method="post">
    <fieldset>
        <legend><?= Kohana::lang('user.login')?></legend>
        <img src="img/user_48.png" alt="<?= Kohana::lang('user.login')?>" /><br />
        <label for="name"><?= Kohana::lang('user.name')?></label>
        <input type="text" name="name" value="" id="name" />
        <br />
        <label for="password"><?= Kohana::lang('user.password')?></label>
        <input type="password" name="password" id="password" />
        <br />
        <div class="center"><input type="submit"  class="button icon-unlock" value="<?= Kohana::lang('user.login')?>" /></div>
    </fieldset>
</form>
