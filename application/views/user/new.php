<h1><?=  Kohana::lang('main.register') ?></h1>
<form action="<?=url::site('register/addUser')?>" method="post" id="new-form" class="floating-labels">
    <div>
        
        <label for="name"><?= Kohana::lang('user.email')?></label>
        <input type="text" name="email" value="<?=$email?>" id="email" class="required email"/><br />
        <label for="name"><?= Kohana::lang('user.name')?></label>
        <input type="text" name="name" value="<?= $name?>" id="name" class="required"/><br />
        <label for="password"><?= Kohana::lang('user.password')?></label>
        <input type="password" name="password" id="password" class="required" /><br />
        <label for="password_again"><?= Kohana::lang('user.retype-password')?></label>
        <input type="password" name="password_again" id="password_again"  /><br />
        <div class="center"> 
            <input type="submit" class="button icon-add" value="<?= Kohana::lang('main.register')?>" />
        </div>
    </div>
</form>

<script type="text/javascript" src="js/jquery-validate/jquery.validate.pack.js "></script>
<script type="text/javascript" src="js/jquery-validate/localization/messages_<?=session::instance()->get('lang','de')?>.js "></script>
<script type="text/javascript" >
    $(function(){
        $("#new-form").validate({
            errorElement : 'small'
        });        
        $("#password_again").rules("add",{

				equalTo: "#password"

        });

    });
</script>