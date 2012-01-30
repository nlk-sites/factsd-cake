<div class="agencyTypes form">
    <?php echo $this->Form->create('AgencyType');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('AgencyType.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/agency_types')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/agency_types/delete/'.$this->Form->value('AgencyType.id'), array('confirm' => 'Are you sure you want to delete this agency type?  This cannot be undone.'));
                echo $this->Form->input('AgencyType.id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>