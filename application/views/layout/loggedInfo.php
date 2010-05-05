<?php if ($_SESSION['auth']["user_id"]) {?>
<div id="loggedInfo">
   <div id="loggedInfoUsername"><?=$_SESSION['auth']["first_name"] ?> <?=$_SESSION['auth']["last_name"] ?> </div>
   <div id="loggedInfoShopperGroup"><?=($_SESSION['auth']['shopperGroup']=='Velkoobchod') ? $_SESSION['auth']['shopperGroup']:'' ?></div>
   <div id="loggedInfoLogout"><a  href="<?$sess->purl(URL . "?page=$modulename/index&amp;func=userLogout");?>"><?= $logout_title ?></a></div>
   <div id="loggedInfoMyAccount"><a href="<?php $sess->purl(SECUREURL . "?page=account/index");?>"><?= $account_title ?></a></div>
 <? if ($perm->check("admin,storeadmin,demo")) { ?>
    <div id="loggedInfoAdministration"> <a   href="<?php $sess->purl(SECUREURL . "?page=product/index"); ?>"><?= $langd["user_administration"];?></a></div>
 <?} ?>
</div>
  <?} ?>


