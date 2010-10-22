<script type="text/javascript" src="scripts/swfobject.js"></script>
<div id="<?=$chart_id?>"></div>
<script type="text/javascript">
    $(function(){

        var flashvars = {'data-file':'<?= $chart_data_url ?>'};
        var params = {allowScriptAccess:'always'};
        var attributes = {};
        swfobject.embedSWF('swf/open-flash-chart.swf', '<?=$chart_id?>','100%',300, '9', '',flashvars,params,attributes);

    });
</script>