<div class="zipAliases index">
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
            <th><?php echo $this->Paginator->sort('name');?></th>
            <th><?php echo $this->Paginator->sort('zip_alias_type_id');?></th>
            <th><?php echo $this->Paginator->sort('region_id');?></th>
            <th><?php echo $this->Paginator->sort('address');?></th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($zipAliases as $zipAlias): ?>
            <tr class="row-type-<?php echo $i++ % 2;?>">
                <td><?php echo h($zipAlias['ZipAlias']['name']); ?>&nbsp;</td>
                <td><?php echo h($zipAlias['ZipAliasType']['name']); ?>&nbsp;</td>
                <td><?php echo h($zipAlias['Region']['name']); ?>&nbsp;</td>
                <td><?php echo h($zipAlias['ZipAlias']['address']); ?>&nbsp;</td>
                <td class="actions" nowrap>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'admin_edit', $zipAlias['ZipAlias']['id'])); ?> | 
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'admin_delete', $zipAlias['ZipAlias']['id']), null, __('Are you sure you want to delete # %s?', $zipAlias['ZipAlias']['id'])); ?>
                    <?php if(!empty($zipAlias['ZipAlias']['address']) || !empty($zipAlias['Zip']))echo ' | '.$this->Html->link(__('View in Google Maps'), array('action' => 'admin_map_address', $zipAlias['ZipAlias']['id']), array('target' => '_blank')); ?>
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
