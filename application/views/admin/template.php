<ul id="admin-menu">
    <li><a <?=is::href('admin/userList',array('admin/*','adminUser/*'))?>><?= Kohana::lang('user.title')?></a></li>
    <li><a <?= is::href('adminVymol')?>><?= Kohana::lang('vymoly.title')?></a></li>
</ul>

<div id="admin-content">
    <?=$content?>
</div>

<script type="text/javascript">
    $(function(){
        $('.confirm').click(function(){            
            return(confirm($(this).attr('title')));
        });
    });
</script>
