<div class="regions index">
    <table class="list">
        <tr>
            <th>Name</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($regions as $region): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($region['Region']['name']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $region['Region']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $region['Region']['id']), null, __('Are you sure you want to delete %s?', $region['Region']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>