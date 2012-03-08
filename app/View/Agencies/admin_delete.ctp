<div class="agencies delete">
    <?php if(!empty($agency_del_data['Program'])){?>
        <h4>Programs</h4>
        <table class="list">
            <tr>
                <th>Program</th>
                <th class="actions"><?php echo __('Actions');?></th>
            </tr>
            <?php
            $i = 1;
            foreach ($agency_del_data['Program'] as $program): ?>
                <tr class="row-type-<?php echo $i++ % 2;?>">
                    <td><?php echo $program['name']; ?></td>
                    <td class="actions" nowrap>
                        <?php echo $this->Html->link(__('Edit Program'), array('controller' => 'programs', 'action' => 'edit', $program['id'], 'admin' => 1), array('target' => '_blank')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php }?>
    <?php if(!empty($agency_del_data['Admin'])){?>
        <h4>Users</h4>
        <table class="list">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th class="actions"><?php echo __('Actions');?></th>
            </tr>
            <?php
            $i = 1;
            foreach ($agency_del_data['Admin'] as $user): ?>
                <tr class="row-type-<?php echo $i++ % 2;?>">
                    <td><?php echo $user['first_name']; ?></td>
                    <td><?php echo $user['last_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td class="actions" nowrap>
                        <?php echo $this->Html->link(__('Edit User'), array('controller' => 'admins', 'action' => 'edit', $user['id'], 'admin' => 1), array('target' => '_blank')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php }?>
</div>