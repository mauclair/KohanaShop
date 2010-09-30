<?php
    $sortable = (isset($sortable)) ? $sortable: array() ;
    $fields = (isset($fields)) ? $fields: array() ;
    $renderers = (isset($renderers)) ? $renderers : array();
    $pagination = isset($pagination) ? $pagination : '';

    //Sanitize fields array to satisfy  $field=>$localized_name patter
    foreach($fields as $field=>$name){
        if(is_int($field)) {
            unset($fields[$field]) ;
            $fields[$name]  = Kohana::lang("$modelname.$name");
        }
    }
    

?>
<?if(isset($title)){?><h1><?=$title?></h1><?}?>

<?= $pagination?>
<table>
    <thead>
        <tr>
            <?foreach($fields as $field=>$name):?>
            <th><?= (in_array($field, $sortable))? show::asort($name,$field,true) : $name; ?></th>
            <?endforeach;?>
        </tr>
        <?foreach($data as $row):
            $row = (array)$row;
         ?>
        <tr <?= text::alternate('','class="even"')?>>
            <? foreach($fields as $field=>$name): ?>
            <td><?
                if(isset($renderers[$field])){
                    echo $renderers[$field]->set($row)->render();
                } else {
                   echo $row[$field];
                }
            ?></td>
            <? endforeach; ?>
        </tr>
        <?endforeach;?>
    </thead>
</table>

<?= $pagination?>