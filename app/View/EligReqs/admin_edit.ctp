<div class="eligReqs form">
    <?php echo $this->Form->create('EligReqs');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('EligReq.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        Options
                    </td>
                    <td class="form-data">
                        <div class="eligReqOptions index">
                            <?php if(!empty($eligReqOptions)){?>
                                <table class="list">
                                    <tr>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Lower Extreme</th>
                                        <th>Upper Extreme</th>
                                        <th class="actions" nowrap><?php echo __('Actions');?></th>
                                    </tr>
                                    <?php
                                    $i = 0;
                                    foreach ($eligReqOptions as $eligReqOption): ?>
                                        <tr class="row-type-<?php echo $i++ % 2;?>">
                                            <td><?php echo h($eligReqOption['EligReqOption']['name']); ?>&nbsp;</td>
                                            <td><?php echo h($eligReqOption['EligReqOption']['weight']); ?>&nbsp;</td>
                                            <td><?php echo h($eligReqOption['EligReqOption']['min']); ?>&nbsp;</td>
                                            <td><?php echo h($eligReqOption['EligReqOption']['max']); ?>&nbsp;</td>
                                            <td class="actions">
                                                <?php echo $this->Html->link(__('Edit'), array('controller' => 'elig_req_options', 'action' => 'admin_edit', $eligReqOption['EligReqOption']['id'])); ?> | 
                                                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'elig_req_options', 'action' => 'admin_delete', $eligReqOption['EligReqOption']['id']), null, __('Are you sure you want to delete %s?', $eligReqOption['EligReqOption']['name'])); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php }?>
                            <?php echo $this->Html->link('Add New Option', '/admin/elig_req_options/add/'.$this->Form->value('EligReq.id'));?>
                        </div>
                    </td>
                </tr>
            <?php }?>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/elig_reqs')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/elig_reqs/delete/'.$this->Form->value('EligReq.id'), array('confirm' => 'Are you sure you want to delete this eligibility requirement?  This cannot be undone.'));
                echo $this->Form->input('EligReq.id', array('label' => FALSE, 'error' => FALSE));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>