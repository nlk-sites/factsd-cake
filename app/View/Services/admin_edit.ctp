<div class="services form">
    <?php echo $this->Form->create('Service'); ?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Service Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Service.name', array('label' => FALSE, 'error' => FALSE)); ?>
                    <?php if ($this->action == 'admin_edit') {
                        echo $this->Form->input('Service.id');
                    }?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/services')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/services/delete/'.$this->Form->value('Service.id'), array('confirm' => 'Are you sure you want to delete this service?  This cannot be undone.'));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>