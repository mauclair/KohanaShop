<form action="user/account_edit" method="post" class="w50pcfl" >
    <div>
        <label for="email"><?= Kohana::lang('user.email')?></label>
        <input class="required email" type="text" id="email" name="email" value="<?= $email?>" /><br />
        <label for="name"><?= Kohana::lang('user.name')?></label>
        <input class="required" type="text" id="name" name="name" value="<?= $name?>" /><br />
        <label for="password"><?= Kohana::lang('user.password')?></label>
        <input type="password" id="password" name="password" value="" /><br />
        <label for="password_again"><?= Kohana::lang('user.retype-password')?></label> 
        <input type="password" id="password_again" name="password_again" value="" /><br />
        <label for="save">&nbsp;</label>
        <input type="submit" id="save" class="button icon-save" value="<?= Kohana::lang('main.save')?>" />
        
    </div>
</form>

<script type="text/javascript" src="js/jquery-validate/jquery.validate.pack.js "></script>
<script type="text/javascript" src="js/jquery-validate/localization/messages_<?=session::instance()->get('lang','de')?>.js "></script>
<script type="text/javascript" >
    $(function(){
        $("form").validate({
            errorElement : 'small'
        });
        $("#password_again").rules("add",{

				equalTo: "#password"

        });

    });
</script>