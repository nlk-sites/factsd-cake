<div class="agency_aliases index">
    <table class="list">
        <tr>
            <th>Name</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($agency_aliases as $agency_alias): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($agency_alias['AgencyAlias']['name']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $agency_alias['AgencyAlias']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $agency_alias['AgencyAlias']['id']), null, __('Are you sure you want to delete %s?', $agency_alias['AgencyAlias']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>