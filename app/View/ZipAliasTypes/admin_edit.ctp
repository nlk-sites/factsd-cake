<div class="zipAliasTypes form">
    <?php echo $this->Form->create('ZipAliasType');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('ZipAliasType.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Abbreviation<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('ZipAliasType.abbreviation', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/zip_alias_types')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/zip_alias_types/delete/'.$this->Form->value('ZipAliasType.id'), array('confirm' => 'Are you sure you want to delete this program?  This cannot be undone.'));
                echo $this->Form->input('ZipAliasType.id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>