<h1><?= Kohana::lang('user.title')?></h1>

<form action="<?=url::site('adminUser/add')?>" method="post" id="update-form" class="floating-labels">
    <div>
        <label for="email"><?= Kohana::lang('user.email')?></label>
        <input type="text" id="email" name="email" class="required email" value="" /><br />

        <label for="name"><?= Kohana::lang('user.name')?></label>
        <input type="text" class="required" name="name" value="" id="name" /><br />
        <label for="password"><?= Kohana::lang('user.password')?></label>
        <input type="password" name="password" id="password" /><br />
        <label for="password_again"><?= Kohana::lang('user.retype-password')?></label>
        <input type="password" name="password_again" id="password_again" /><br />
        <input type="hidden" name="user_id" value="" />
        <label for="level"><?= Kohana::lang('user.level')?></label>
        <?= form::dropdown('level', Kohana::lang('user.levels'),255)?><br/>
        <label>&nbsp;</label>
            <input type="submit" class="button icon-add" value="<?= Kohana::lang('main.register')?>" />

    </div>
</form>


<script type="text/javascript" src="js/jquery-validate/jquery.validate.pack.js "></script>
<script type="text/javascript" src="js/jquery-validate/localization/messages_<?=session::instance()->get('lang','de')?>.js "></script>
<script type="text/javascript" >
    $(function(){
        $("#update-form").validate({errorElement : 'small'});
        $("#password_again").rules("add",{
				equalTo: "#password"

        });
    });
</script>
