<h1><?= Kohana::lang('user.lost-password')?></h1>
<p><?= Kohana::lang('user.lost-password-message')?></p>
<form action="<?= url::site('register/lostPasswordSend')?>" method="post" class="floating-labels">
    <div>
        
        <label for="email"><?= Kohana::lang('user.email')?></label>
        <input type="text" id="email" name="email" value="" />
        <input type="submit" value="<?= Kohana::lang('main.send')?>" />
    </div>
</form>