<? foreach($banners as $k=>$data):
    if(count($data)==0) continue;
?>
<div id="<?=$k?>">
    <?foreach($data as $item):?>
        <?= View::factory('banner_item')->set($item)->render()?>
    <?endforeach;?>
</div>
<?endforeach;?>