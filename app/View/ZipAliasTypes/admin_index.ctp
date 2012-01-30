<div class="zipAliasTypes index">
    <table class="list">
        <tr>
            <th>Name</th>
            <th>Abbreviation</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($zipAliasTypes as $zipAliasType): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($zipAliasType['ZipAliasType']['name']); ?>&nbsp;</td>
                <td><?php echo h($zipAliasType['ZipAliasType']['abbreviation']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $zipAliasType['ZipAliasType']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $zipAliasType['ZipAliasType']['id']), null, __('Are you sure you want to delete %s?', $zipAliasType['ZipAliasType']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>