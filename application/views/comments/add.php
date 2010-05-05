<img src="imgs/add_24.png"   id="toggle-add-comment-form" title="<?= Kohana::lang('main.add')?>" alt="<?= Kohana::lang('main.add')?>"/>
<form action="<?= url::site('comments/add')?>" id="add-comment-form" method="post" class="hide">    
    <textarea cols="40" rows="5" id="comment" name="comment" style="width:100%"></textarea>
    <input type="hidden" id="user_id" name="user_id" value="<?=Session::instance()->get('user.user_id')?>" />
    <input type="hidden" id="vymol_id" name="vymol_id" value="<?=$vymol_id?>" />
    <input type="submit"  value="<?= Kohana::lang('main.add')?>" />
</form>