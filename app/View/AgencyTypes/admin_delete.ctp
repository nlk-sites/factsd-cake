<div class="agency_types delete">
    <table class="list">
        <tr>
            <th>Agency</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($agencies_types['Agency'] as $agency): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo $agency['name']; ?></td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit Agency'), array('controller' => 'agencies', 'action' => 'edit', $agency['id'], 'admin' => 1), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>