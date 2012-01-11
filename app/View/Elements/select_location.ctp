<div id="select_loc_<?php echo $location_type;?>" class="pop_location">
    <div class="pop_arrow">arrow</div>
    <a href="#" class="pop_close">close</a>
    <div class="pop_title">Select from the following</div>
    <div class="select_radio">
        <?php echo $this->Form->radio($location_type.'.zip_alias_type_id', $zip_alias_types, array('default' => 1, 'onChange' => 'change_loc_selects("'.$location_type.'", $(this).val());', 'separator' => '</div><div class="select_radio">', 'legend' => FALSE));?>
    </div>
    <?php foreach($zip_aliases as $type_id => $aliases){
        $attributes = ($type_id == 1 ? array() : array('disabled' => 'disabled', 'style' => 'display:none;'));
        $attributes['empty'] = 'Select from '.$zip_alias_types[$type_id];
        echo $this->Form->select($location_type.'.zip_alias_id'.$type_id, $aliases, $attributes);
    }?>
    <div class="pop_submit_row">
        <?php echo $this->Form->submit('GO', array('onClick' => 'insert_location("'.$location_type.'");return false;', 'class' => 'input_go', 'div' => FALSE));?>
        <a href="#" class="pop_close_word">Cancel</a>
    </div>
</div>