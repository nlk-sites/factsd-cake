<div class="services index">
    <table class="list">
        <tr>
            <th>Service</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($services as $service): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($service['Service']['name']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $service['Service']['id'])); ?>
                    |
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $service['Service']['id']), null, __('Are you sure you want to delete %s?', $service['Service']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>