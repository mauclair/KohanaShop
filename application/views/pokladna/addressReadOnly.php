<?if($company):?>
    <div class="addr-company"><?= $company ?></div>
    <?if(isset($hideico)):?>
            <div class="addr-ico">
                    <?= Kohana::lang('user.ico')?>: <?=$ico?>
                    <?= Kohana::lang('user.dico')?>: <?=$dico?>
            </div>
     <?endif;?>
<?endif;?>
<div class="addr-name"><?= $name ?></div>
<div class="addr-street"><?= $address_1 ?></div>
<div class="addr-city"><?=$zip?>, <?= $city ?></div>

