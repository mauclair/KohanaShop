<?php
    
    $fields = (isset($fields)) ? $fields: array() ;
    $sortable = (isset($sortable)) ? $sortable: $fields ;
    $pagination = isset($pagination) ? $pagination : '';
    $sort = (isset($sort))?$sort : array();
    
   // $viewHeader = isset($viewHeader) ? $viewheader  : View::factory('admin/generic/header')->set('fields',$fields)->set('sortable',$sortable);

    //Sanitize fields array to satisfy  $field=>$localized_name patter
    foreach($fields as $field=>$name){
        if(is_int($field)) {
            unset($fields[$field]) ;
            $fields[$name]  = Kohana::lang("$modelname.$name");
        }
    }

    $viewRow = isset($viewRow) ? $viewRow  : View::factory('admin/generic/row')->set('fields',$fields);
    

?>
<?if(isset($title)){?><h1><?=$title?></h1><?}?>

<?= $pagination?>
<table>
    <thead>
        <tr>
            <?foreach($fields as $field=>$name):?>
            <th><?= (in_array($field, $sortable))? show::asort($name,$field,$sort) : $name; ?></th>
            <?endforeach;?>
            <th></th>
        </tr>
        <?foreach($data as $row){
            $row = (array)$row;
            echo $viewRow->set($row)->render();
         }?>
        
        
    </thead>
</table>

<?= $pagination?>