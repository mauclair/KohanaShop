<script type="text/javascript">
    var unameExists = '<?=Kohana::lang('error.username_exists') ?>' ;
    var pwdMatch = '<?= Kohana::lang('error.passwords_match') ?>';
    var formNotValid = '<?=Kohana::lang('error.form_not_valid') ?>';
    var captcha =  '<?= md5('capcha') ?>';
    var timer;
</script>


<h1><?= Kohana::lang('user.login') ?></h1>

<ul id="tabs">
    <li class="current"><?= Kohana::lang('main.register')?></li>
    <li><?= Kohana::lang('user.log-in')?></li>
</ul>

<div id="panes">
    <?= $register?>
    <?=  View::factory('user/login_form')?>
</div>


<script type="text/javascript" src="./scripts/jquery.tools.min.js"></script>
<script type="text/javascript" src="./scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="./scripts/localization/messages_cs.js"></script>
<script type="text/javascript">
    $(function(){
        $("#tabs").tabs("#panes > form");
        $("#Register").validate({errorElement : 'div'});
    });

</script>