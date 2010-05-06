<div class="right">
    <a href="<?= url::site('adminArticles/newArticle')?>"><img src="img/add_48.png" alt="<?= Kohana::lang('main.add')?>" title="<?= Kohana::lang('main.add')?>" /></a>
</div>
<h1><?= Kohana::lang('articles.title')?></h1>
<table>
    <tr>
        <th><?= Kohana::lang('articles.article_title')?></th>        
        <th></th>
    </tr>

<? foreach ($articles as $a):?>
    <tr>
        <td><a class="icon-edit-right" href="<?= url::site('adminArticles/edit/'.$a->article_id)?>"><?= $a->article_title?></a></td>
        <td>
            <a class="confirm icon-delete button" href="<?= url::site('adminArticles/delete/'.$a->article_id)?>"><?= Kohana::lang('main.delete')?></a>
        </td>
    </tr>
<?endforeach;?>
</table>