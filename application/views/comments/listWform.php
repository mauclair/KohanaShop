<h2><?= Kohana::lang('comments.title')?></h2>
<?if(User_Model::isLogged()) echo View::factory('comments/add')->set('vymol_id',$vymol_id)->render(); ?>
<?= $comments ?>