<div class="tabs3">
    <h2><a href="<?= url::site('uzivatel/prihlasit')?>"><?= Kohana::lang('user.log-in')?></a></h2>
    <h2><a href="<?=  url::site('uzivatel/registrovat_se')?>"><?= Kohana::lang('user.register')?></a></h2>
    <h2><a href="<?=  url::site('pokladna/bezRegistrace')?>"><?= Kohana::lang('pokladna.quick-buy')?></a></h2>
</div>
<div id="pane">
</div>

<script type="text/javascript" src="./scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="./scripts/localization/messages_cs.js"></script>
<script src="scripts/jquery.tools.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var api;

    $(function(){
        api = $('.tabs3').tabs('#pane',{effect: 'ajax',api:true});
        api.onClick(function(event,index){
            if(index==1) { //
                $('#Register').validate();
            }
        });
    });
    
</script>