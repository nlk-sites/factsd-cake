<div class="elig_reqs delete">
    <table class="list">
        <tr>
            <th>Program</th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($programs as $program_id => $program_name): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo $this->Html->link(__($program_name), array('controller' => 'programs', 'action' => 'edit', $program_id, 'admin' => 1), array('target' => '_blank')); ?></td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit Program Eligibility Reqs'), array('controller' => 'programs', 'action' => 'elig', $program_id, 'admin' => 1), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>