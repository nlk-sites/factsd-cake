<div class="eligReqOptions form">
    <?php echo $this->Form->create('EligReqOptions'); ?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Option Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('EligReqOption.name', array('label' => FALSE, 'error' => FALSE)); ?>
                    <?php if ($this->action == 'admin_edit') {
                        echo $this->Form->input('EligReqOption.id');
                    }?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Weight<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('EligReqOption.weight', array('label' => FALSE, 'error' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Lower Extreme
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('EligReqOption.min', array('label' => FALSE, 'error' => FALSE, 'type' => 'text')); ?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Upper Extreme
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('EligReqOption.max', array('label' => FALSE, 'error' => FALSE)); ?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/elig_reqs/edit/'.$elig_req_id)."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/elig_req_options/delete/'.$this->Form->value('EligReqOption.id'), array('confirm' => 'Are you sure you want to delete this eligibility requirement option?  This cannot be undone.'));
            }else{
                echo $this->Form->input('EligReqOption.elig_req_id', array('type' => 'hidden', 'value' => $elig_req_id));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>