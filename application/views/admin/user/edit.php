<h1><?= Kohana::lang('user.title')?></h1>
<h2><?= $name ?></h2>
<form action="<?=url::site('adminUser/update')?>" method="post" id="update-form" class="floating-labels">
    <div>        
        <label for="email"><?= Kohana::lang('user.email')?></label>
        <input type="text" id="email" name="email" value="<?= $email?>" /><br />

        <label for="name"><?= Kohana::lang('user.name')?></label>
        <input type="text" name="name" value="<?=$name?>" id="name" /><br />
        <label for="password"><?= Kohana::lang('user.password')?></label>
        <input type="password" name="password" id="password" /><br />
        <label for="password_again"><?= Kohana::lang('user.retype-password')?></label>
        <input type="password" name="password_again" id="password_again" /><br />
        <input type="hidden" name="user_id" value="<?= $user_id?>" />
        <label for="level"><?= Kohana::lang('user.level')?></label>
        <?= form::dropdown('level', Kohana::lang('user.levels'), $level)?><br/>
        <label>&nbsp;</label>
            <a onclick="$('form').submit()" class="icon-save button"><?= Kohana::lang('main.save')?></a>
            <input type="submit" value="<?= Kohana::lang('main.save')?>" class="hide" />
            <a class="icon-delete button confirm" href="<?= url::site('user/delete/'.$user_id)?>" title="<?= Kohana::lang('main.delete')?> : <?= $name?> ?"><?= Kohana::lang('main.delete')?> </a>
        
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