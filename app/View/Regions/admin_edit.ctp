<div class="regions form">
    <?php echo $this->Form->create('Region');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Region.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/regions')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/regions/delete/'.$this->Form->value('Region.id'), array('confirm' => 'Are you sure you want to delete this region?  This cannot be undone.'));
                echo $this->Form->input('Region.id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>