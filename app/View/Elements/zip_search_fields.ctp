<fieldset>
    <div class="path_block">
        <div class="path_title">YOUR PICK UP LOCATION</div>
        <?php echo $this->Form->input('Program.origin', array('class' => 'input_txt', 'label' => false)); ?>
        <a href="#" id="select_location_link_Origin" onClick="show_location_select($(this), 'Origin', 'loc');return false;" class="btn_other">or select a location</a>
    </div>
    <div class="path_ico"><?php echo $this->Html->image('ico_arrow2.gif'); ?></div>

    <div class="path_block">
        <div class="path_title">GOING TO</div>
        <?php echo $this->Form->input('Program.destination', array('class' => 'input_txt', 'label' => false)); ?>
        <a href="#" id="select_location_link_Destination" onClick="show_location_select($(this), 'Destination', 'loc');return false;" class="btn_other">or select a location</a>
    </div>

    <?php echo $this->Form->submit('FIND A RIDE', array('id' => 'submit_filters', 'onClick'=>'submit_form(0);return false;', 'class' => 'input_submit'));?>
</fieldset>
<?php echo $this->element('select_location', array('zip_alias_types' => $zip_alias_types, 'location_type' => 'Origin')); ?>
<?php echo $this->element('select_location', array('zip_alias_types' => $zip_alias_types, 'location_type' => 'Destination')); ?>
