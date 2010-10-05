<tr <?= text::alternate('','class="even"')?>>
            <? foreach($fields as $field=>$fieldname): ?>
            <td><?= $$field; ?></td>
            <? endforeach; ?>
</tr>