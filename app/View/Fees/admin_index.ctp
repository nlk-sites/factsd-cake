<div class="fees index">
    <?php if(empty($fees)){?>
        <div class="no_data_table">
            <p>There are currently no fees for this program.</p>
            <p><?php echo $this->Html->link('Please add fee information by clicking here.', array('action' => 'add', $program_info['Program']['id']));?></p>
            <p>It is important that you add fee information, <b>even if the program is free</b>.<p>
        </div>
    <?php }else{ ?>
        <table class="list">
            <tr>
                <th>Fee Type</th>
                <th>Fee</th>
                <th>Description</th>
                <th class="actions"><?php echo __('Actions');?></th>
            </tr>
            <?php 
            $i = 1;
            foreach($fees as $f){?>
                <tr class="row-type-<?php echo $i++ % 2;?>">
                    <td><?php echo $f['FeeType']['name'];?></td>
                    <td><?php echo $f['Fee']['fee'];?></td>
                    <td><?php echo $f['Fee']['description'];?></td>
                    <td class="actions" nowrap>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $f['Fee']['id'])); ?> |
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $f['Fee']['id']), null, __('Are you sure you want to delete this fee?')); ?>
                    </td>
                </tr>
            <?php }?>
        </table>
    <?php }?>
</div>