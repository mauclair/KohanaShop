<div id="indikace-assigned">
<?foreach($tags as $tag):?>
    <div id="indikace_id-<?= $tag->indikace_id?>"><?= $tag->indikace_name ?></div>
<?  endforeach;?>
</div>