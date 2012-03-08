<div class="zip_alias_types delete">
    <table class="list">
        <tr>
            <th>Zip Alias</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($zip_aliases['ZipAlias'] as $zip_alias): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo $zip_alias['name']; ?></td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit Zip Alias'), array('controller' => 'zip_aliases', 'action' => 'edit', $zip_alias['id'], 'admin' => 1), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>