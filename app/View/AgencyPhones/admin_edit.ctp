<div class="agencyPhones form">
    <?php echo $this->Form->create('AgencyPhone');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Phone Number<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('AgencyPhone.phone', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Phone Type
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('AgencyPhone.type', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Note
                </td>
                <td class="form-data" colspan="3">
                    <?php echo $this->Form->input('AgencyPhone.note', array('label' => FALSE, 'error' => FALSE, 'style' => 'width: 100%;'));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/agencies/edit/'.$agency_id)."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/agency_phones/delete/'.$this->Form->value('AgencyPhone.id'), array('confirm' => 'Are you sure you want to delete this phone?  This cannot be undone.'));
                echo $this->Form->input('AgencyPhone.id');
            }else{
                echo $this->Form->hidden('AgencyPhone.agency_id', array('value' => $agency_id));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>