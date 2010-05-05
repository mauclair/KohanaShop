<ol>
<? foreach($comments as $c):?>
    <li>
        <h3><?=$c->name?></h3>
        <div class="comment-date"><?= $c->nice_date?>
            <?if(User_Model::isAdmin()):?>
            <a class="comment-delete" href="<?= url::site('comments/delete/'.$c->comment_id)?>"><img src="imgs/cancel_16.png" title="<?= Kohana::lang('main.delete')?>" alt="<?= Kohana::lang('main.delete')?>" /></a>
            <?endif;?>
        </div>
        <p><?= $c->comment?></p>
    </li>
<?endforeach;?>
</ol>