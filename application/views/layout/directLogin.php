<form action="<?=url::site('user/login')?>" method="post" id="upLogin">
    <div  id="directLogin">        
        <div id="directLoginUsername"><input type="text" name="username"  /></div>
        <div id="directLoginPassword"><input type="password" name="password" /></div>
        <div id="directLoginSubmit"><input type="submit" name="Login" value="<?= Kohana::lang('user.login')?>" /></div>
    </div>
</form>
