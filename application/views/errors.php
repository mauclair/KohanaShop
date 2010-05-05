<div id="messages">
<?php foreach($errors as $e):?>
<div class="<?=$e['class']?>"><?=$e['value']?></div>
<? endforeach;?>
</div>
<script type="text/javascript" >
    $(function(){
        $("#messages").delay(2500).fadeOut('slow');
    });
</script>