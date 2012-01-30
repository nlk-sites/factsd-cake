<div class="zipAliases form">
    <?php if($this->action == 'admin_edit' && isset($select_zips)){?>
        <div class="message">
            This zip alias has no zipcodes associated with it.  <?php echo $this->Html->link('Add zipcodes here.', array('action' => 'admin_edit_zips', $this->Form->value('ZipAlias.id')));?>
        </div>
        <br style="line-height:5px" />
    <?php }?>
    <?php echo $this->Form->create('ZipAlias');?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('ZipAlias.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Zip Alias Type<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('ZipAlias.zip_alias_type_id', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Region
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('ZipAlias.region_id', array('label' => FALSE, 'error' => FALSE, 'empty' => true));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Address
                </td>
                <td colspan="5" class="form-data">
                    <?php echo $this->Form->input('ZipAlias.address', array('label' => FALSE, 'error' => FALSE, 'style' => 'width: 100%;'));?>
                </td>
            </tr>
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        Zips
                    </td>
                    <td colspan="5" class="form-data">
                        <?php if(isset($alias_zips) && !empty($alias_zips)){
                            echo implode(', ', $alias_zips).'<br />';
                        }?>
                        <?php echo $this->Html->link('Add/Edit Associated Zips', '/admin/zip_aliases/edit_zips/'.$this->Form->value('ZipAlias.id'));?>
                    </td>
                </tr>
            <?php }?>
        </table>
        <?php if($this->action == 'admin_add'){?>
            <div class="zipAliases form" style="padding-top:10px;">
                <h4>Associated Zipcodes</h4>
                <?php echo $this->Element('zip_checkboxes');?>
            </div>
        <?php }?>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/zip_aliases')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/zip_aliases/delete/'.$this->Form->value('ZipAlias.id'), array('confirm' => 'Are you sure you want to delete this zip alias?  This cannot be undone.'));
                echo $this->Form->input('ZipAlias.id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>