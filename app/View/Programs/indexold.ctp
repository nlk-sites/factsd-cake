<?php echo $this->Form->create('Program');?>
<?php echo $this->element('zip_search_fields');?>
<?php foreach($locations as $zip_type => $zips){
    echo $this->Form->hidden('Location.'.$zip_type, array('value' => (is_array($zips) ? implode(',', $zips) : $zips)));
}?>
<?php foreach($addresses as $address_type => $addresses){
    echo $this->Form->hidden('Address.'.$address_type, array('value' => (is_array($addresses) ? '' : $addresses)));
}?>
<?php echo $this->element('map');?>
<div id="select_address_Origin" style="display:none;">
    <p>The starting address you entered was not found.</p>
    <p>Did you mean:</p>
    <ul>
    </ul>
</div>
<div id="select_address_Destination" style="display:none;">
    <p>The ending address you entered was not found.</p>
    <p>Did you mean:</p>
    <ul>
    </ul>
</div>
<div id="filters">
    <h2>Filter Options</h2>
    <div id="filter_services">
        <h3>Specific Services You Require</h3>
        <div>
            <?php foreach($services as $service_id => $service_label){
                echo $this->Form->input('Service.id.'.$service_id, array('type'=>'checkbox', 'label'=>$service_label, 'value' => $service_id));
            }?>
        </div>
    </div>
    <div id="filter_eligibility">
        <h3>Eligibility Requirements</h3>
        <div>
            <?php echo $this->Form->radio('Eligibility.reqs', array(0 => 'Show All', 1 => 'Eligibility required', 2 => 'Open to public'), array('default' => 0, 'legend' => false));?>
        </div>
    </div>
    <div id="filter_eligibility">
        <h3>Fees</h3>
        <div>
            <?php echo $this->Form->radio('Fee.fee', array(0 => 'Show All', 1 => 'No Fee', 2 => 'Flat Fare Under $5', 3 => 'Flat Fare $5 - $15', 4 => 'Other Fee Structure'), array('default' => 0, 'legend' => false));?>
        </div>
    </div>
</div>


<?php
//echo $this->Js->submit('FIND A RIDE', array('update' => '#content_for_update', 'evalScripts' => true, 'id' => 'submit_filters'));
echo $this->Form->submit('FIND A RIDE', array('id' => 'submit_filters', 'onClick="submit_form(0);return false;"'));
echo $this->Form->end();?>

<div class="programs index">
	<h2><?php echo __('Programs');?></h2>
    <div id="content_for_update">
        <?php echo $this->element('search_results');?>
    </div>
</div>
<script type="text/javascript">
function insert_location(loc){
    loc_div = $('#select_loc_'+loc);
    selected_loc = loc_div.find('select:not([disabled]) option:selected');
    if(selected_loc.val() == ""){
        alert('Please select from the list of '+loc_div.find("input[type='radio']:checked + label").text()+'.');
    }else{
        $('#Program'+loc).val(selected_loc.text());
        loc_div.hide();
    }
}

function select_address(address, loc_type){
    //alert(address);
    //alert('#Program'+loc_type);
    $('#Program'+loc_type).val(address);
    $('#select_address_'+loc_type).hide();
    $('#select_address_'+loc_type+' ul').empty();
    //if(loc_type=='Destination'){
    //    submit_form(0);
    //}
}

function change_loc_selects(loc, alias_type){
    if(alias_type==0){
        alias_type = $('#select_loc_'+loc+' input[type="radio"]:checked').val();
    }
    $('#select_loc_'+loc+' select:not([disabled="disabled"])').attr('disabled', 'disabled').hide();
    $('#'+loc+'ZipAliasId'+alias_type).attr('disabled', false).show();
}
//calcRoute
function submit_form(filter){
    //$.ajax({data:$("#submit_filters").closest("form").serialize(), dataType:"html", evalScripts:true, success:function (data, textStatus) {$("#content_for_update").html(data);}, type:"post", url:form_url});
    //alert($("#ProgramIndexForm").serialize());
    //alert($("#ProgramIndexForm").attr('action'));
    if(filter==0){
        $('#trip_duration').hide();
    }
    $.ajax({data:$("#ProgramIndexForm").serialize()+'&data%5Bfilter%5D='+filter, dataType:"html", evalScripts:true, success:function (data, textStatus) {$("#content_for_update").html(data);}, type:"post", url:$("#ProgramIndexForm").attr('action')});
    return false;
}

function hide_address_select(loc_type){
    if($('#select_address_'+loc_type+':visible').length > 0){
        $('#select_address_'+loc_type).hide();
        $('#select_address_'+loc_type+' ul').empty();
    }
}

function show_location_select(loc_type){
    hide_address_select(loc_type);
    $('#select_loc_'+loc_type).show();
}

$(document).ready(function(){
    change_loc_selects('Origin', 0);
    change_loc_selects('Destination', 0);
    $('#ProgramOrigin').change(function(){hide_address_select('Origin')});
    $('#ProgramDestination').change(function(){hide_address_select('Destination')});
});

//$("#submit_filters").bind("click", function (event) {$.ajax({data:$("#submit_filters").closest("form").serialize(), dataType:"html", evalScripts:true, success:function (data, textStatus) {$("#content_for_update").html(data);}, type:"post", url:"\/fact\/programs"});
//return false;});
</script>

<?php $this->Js->get('#filters :input')->event('change', 'submit_form(1);');?>
<?php echo $this->Js->writeBuffer();?>