<div class="reviews index">
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
            <th><?php echo $this->Paginator->sort('Program.name', 'Program');?></th>
            <th><?php echo $this->Paginator->sort('name', 'Name');?></th>
            <th><?php echo $this->Paginator->sort('approved');?></th>
            <th><?php echo $this->Paginator->sort('review');?></th>
            <th><?php echo $this->Paginator->sort('created');?></th>
            <th><?php echo $this->Paginator->sort('modified');?></th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 1;
        foreach ($reviews as $review): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td>
                    <?php echo $this->Html->link($review['Program']['name'], array('controller' => 'programs', 'action' => 'edit', $review['Program']['id'], 'admin' => TRUE)); ?>
                </td>
                <td><?php echo h($review['Review']['name']); ?>&nbsp;</td>
                <td><?php echo ($review['Review']['approved'] == 1 ? 'Yes' : 'No'); ?>&nbsp;</td>
                <td><?php echo substr($review['Review']['review'], 0, 60).(strlen($review['Review']['review']) > 60 ? '...' : '');?>&nbsp;</td>
                <td><?php echo date('M j, Y', strtotime($review['Review']['modified'])); ?>&nbsp;</td>
                <td><?php echo date('M j, Y', strtotime($review['Review']['created'])); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $review['Review']['id'])); ?>
                    |
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $review['Review']['id']), null, __('Are you sure you want to delete this review of %s by %s?', $review['Program']['name'], $review['Review']['name'])); ?>
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
