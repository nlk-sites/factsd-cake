<div class="agency_aliases form">
    <?php echo $this->Form->create('AgencyAlias');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('AgencyAlias.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/agency_aliases/index/'.$agency_data['Agency']['id'])."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/agency_aliases/delete/'.$this->Form->value('AgencyAlias.id'), array('confirm' => 'Are you sure you want to delete this agency alias?  This cannot be undone.'));
                echo $this->Form->input('AgencyAlias.id');
            }else{
                echo $this->Form->input('AgencyAlias.agency_id', array('type' => 'hidden', 'value' => $agency_data['Agency']['id']));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>