<? $prefix  = (isset($prefix)) ?  $prefix :'';?>  
<div>
    <label for="<?= $prefix?>firm-toggle"><?= Kohana::lang('user.firma')?></label>
    <input id="<?= $prefix?>firm-toggle" type="checkbox"  onclick="$('#firma<?=$prefix?>').slideToggle()"/><br />
    <div <?= ($company) ? ''  :'class="hidden"'  ?> id="firma<?=$prefix?>">
        <label for="<?=$prefix?>company" ><?= Kohana::lang('user.company') ?></label>
        <input type="text" class="w4" name="<?=$prefix?>company" id="<?=$prefix?>company" value="<?= $company ?>" />
        <br />
<?if(!$prefix):?>
        <label for="<?=$prefix?>ico" ><?= Kohana::lang('user.ico') ?></label>
        <input type="text" class="w1" name="<?=$prefix?>ico" id="<?=$prefix?>ico" value="<?= $ico ?>" />

        <label for="<?=$prefix?>dico" ><?= Kohana::lang('user.dico') ?></label>
        <input type="text" name="<?=$prefix?>dico" class="w1" id="<?=$prefix?>dico" value="<?= $dico ?>" />
<?endif;?>
    </div>

    <label for="<?=$prefix?>name" ><?= Kohana::lang('user.name')?>*</label>
    <input type="text" name="<?=$prefix?>name" class="w4 required" id="<?=$prefix?>first_name" value="<?= $name ?>" />
    <br />

    <label for="<?=$prefix?>address_1" ><?= Kohana::lang('user.address_1') ?>*</label>
    <input type="text"  class="w4 required" name="<?=$prefix?>address_1" id="<?=$prefix?>address_1" value="<?= $address_1 ?>" />
    <br />

    <label for="<?=$prefix?>zip" ><?= Kohana::lang('user.zip') ?>*</label>
    <input type="text" class="w05 required" name="<?=$prefix?>zip" id="<?=$prefix?>zip" value="<?= $zip ?>"  class="required"/>

    <label for="<?=$prefix?>city"><?= Kohana::lang('user.city') ?>*</label>
    <input type="text" name="<?=$prefix?>city" id="<?=$prefix?>city" value="<?= $city ?>"  class="required w25"/><br />



    <label for="<?=$prefix?>country"><?= Kohana::lang('user.country') ?></label>
    <input type="text" name="<?=$prefix?>country" id="<?=$prefix?>country" value="Česká republika"/>

    <?if(isset($user_info_id)){?><input type="hidden" name="<?= $prefix?>user_info_id" value="<?= $user_info_id?>"/><?}?>

</div>


