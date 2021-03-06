<div class="programs index">
    <div>
        <?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'));?>
        <div class="pager_results_per_page">
            Results Per Page: 
            <?php 
            $options = $this->Paginator->params();
            $results_per = array(20, 50, 100, 'All');
            foreach($results_per as &$num){
                if($num == 'All'){
                    $num_text = 'All';
                    $num = 99999;
                }else{
                    $num_text = $num;
                }
                if($options['limit'] == $num){
                    $num = $num_text;
                }else{
                    $num = $this->Paginator->link($num_text, array('limit' => $num, 'page' => 1));
                }
            }
            echo implode(' | ', $results_per);
            ?>
        </div>
    </div>
    <table class="list">
        <tr>
            <th><?php echo $this->Paginator->sort('name', 'Program');?></th>
            <?php if($user_level >= 1000){?>
                <th><?php echo $this->Paginator->sort('Agency.name', 'Agency');?></th>
            <?php }?>
            <th><?php echo $this->Paginator->sort('url');?></th>
            <th><?php echo $this->Paginator->sort('phone');?></th>
            <th><?php echo $this->Paginator->sort('created');?></th>
            <th><?php echo $this->Paginator->sort('modified');?></th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($programs as $program): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($program['Program']['name']); ?>&nbsp;</td>
                <?php if($user_level >= 1000){?>
                    <td>
                        <?php echo $this->Html->link($program['Agency']['name'], array('controller' => 'agencies', 'action' => 'edit', $program['Agency']['id'])); ?>
                    </td>
                <?php }?>
                <td><?php if(!empty($program['Program']['url']))echo $this->Html->link(substr($program['Program']['url'], 0, 20).(strlen($program['Program']['url']) > 20 ? '...' : ''), (strpos($program['Program']['url'], 'http://') === 0 || strpos($program['Program']['url'], 'https://') === 0 ? '' : 'http://').$program['Program']['url']); ?>&nbsp;</td>
                <td><?php echo h($program['Program']['phone']); ?>&nbsp;</td>
                <td><?php echo date('M j, Y', strtotime($program['Program']['modified'])); ?>&nbsp;</td>
                <td><?php echo date('M j, Y', strtotime($program['Program']['created'])); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $program['Program']['id'])); ?>
                    |
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $program['Program']['id']), null, __('Are you sure you want to delete %s?', $program['Program']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p class="paging">
        <?php if($this->Paginator->hasPrev())echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'))." | ";?>
        <?php echo $this->Paginator->numbers(array('separator' => ' | '));?>
        <?php if($this->Paginator->hasNext())echo ' | '.$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?>
    </p>
</div>
