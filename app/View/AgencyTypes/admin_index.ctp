<div class="agencyTypes index">
    <table class="list">
        <tr>
            <th>Name</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($agency_types as $agency_type): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($agency_type['AgencyType']['name']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $agency_type['AgencyType']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $agency_type['AgencyType']['id']), null, __('Are you sure you want to delete %s?', $agency_type['AgencyType']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>