<div class="services delete">
    <table class="list">
        <tr>
            <th>Program</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($program_services['Program'] as $program): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo $this->Html->link(__($program['name']), array('controller' => 'programs', 'action' => 'edit', $program['id'], 'admin' => 1), array('target' => '_blank')); ?></td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit Program Services'), array('controller' => 'programs', 'action' => 'services', $program['id'], 'admin' => 1), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>