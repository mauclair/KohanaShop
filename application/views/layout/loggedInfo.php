<?php
    if (is::logged()) {
    $u = Session::instance()->get('user');
?>
<div id="loggedInfo">
   <div id="loggedInfoUsername"><?=$u['name']?></div>
   <div id="loggedInfoShopperGroup"><?=($u['shopper_group_name']=='Velkoobchod') ? $u['shopper_group_name']:'' ?></div>
   <div id="loggedInfoLogout"><a  href="<?= url::site('uzivatel/logout')?>"><?= Kohana::lang('user.logout')?></a></div>
   <div id="loggedInfoMyAccount"><a <?= is::href('ucet', array('ucet/*'))?>><?= Kohana::lang('user.account')?></a></div>
 <? if ( User_Model::isAdmin()){ ?>
   <div id="loggedInfoAdministration"> <a   href="<?= url::site('admininstrace')?>"><?= Kohana::lang('admin.title')?></a></div>
 <?} ?>
</div>
  <?} else {?>
<form id="upLogin" method="post" action="<?= url::site('uzivatel/login')?>">
    <div id="directLogin">
        <div>
            <input type="hidden" value="" name="page">
            <input type="hidden" value="userLogin" name="func">
        </div>
        <div id="directLoginUsername"><input type="text" size="16" maxlength="32" name="username"></div>
        <div id="directLoginPassword"><input type="password" size="16" maxlength="32" name="password"></div>
        <div id="directLoginSubmit"><input type="submit" value="Přihlásit" name="Login"></div>
    </div>
</form>
<?  }?>


