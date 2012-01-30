<div class="zipAliases form">
    <?php echo $this->Form->create('ZipAlias');?>
        <?php echo $this->Element('zip_checkboxes');?>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/zip_aliases/edit/'.$this->params['pass'][0])."';"));?>
        </div>
    <?php echo $this->Form->end();?>
</div>