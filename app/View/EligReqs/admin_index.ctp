<div class="eligReqs index">
    <table class="list">
        <tr>
            <th>Name</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($eligReqs as $eligReq): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($eligReq['EligReq']['name']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $eligReq['EligReq']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $eligReq['EligReq']['id']), null, __('Are you sure you want to delete %s?', $eligReq['EligReq']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
