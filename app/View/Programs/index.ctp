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
    $('#Program'+loc_type).val(address);
    $('#select_address_'+loc_type).hide();
}

function change_loc_selects(loc, alias_type){
    if(alias_type==0){
        alias_type = $('#select_loc_'+loc+' input[type="radio"]:checked').val();
    }
    $('#select_loc_'+loc+' select:not([disabled="disabled"])').attr('disabled', 'disabled').hide();
    $('#'+loc+'ZipAliasId'+alias_type).attr('disabled', false).show();
}

function submit_form(filter){
    if(filter==0){
        $('#trip_duration').hide();
    }
    $.ajax({data:$("#ProgramIndexForm").serialize()+'&data%5Bfilter%5D='+filter, dataType:"html", evalScripts:true, success:function (data, textStatus) {$("#content_for_update").html(data);}, type:"post", url:$("#ProgramIndexForm").attr('action')});
    return false;
}

function hide_address_select(loc_type){
    if($('#select_address_'+loc_type+':visible').length > 0){
        $('#select_address_'+loc_type).hide();
    }
}

function show_location_select(link, loc_type, address){
    hide_address_select(loc_type);
    var trigger_offset_x=link.offset().left-300;
    var trigger_offset_y=link.offset().top-110;
    $('#select_'+address+'_'+loc_type).css({"left":trigger_offset_x, "top":trigger_offset_y}).fadeIn(200);
    return false;
}

function set_address_options(address_type, addresses){
    var address_ul = $('#select_address_'+address_type+' ul.select_address_ul');
    address_ul.empty();
    $.each(addresses, function(i) {
        address_ul.append(
            $('<li>').append(
                $('<a>').attr('href', '#').append(addresses[i])
        ));
    });
    address_ul.find('a').click( function(){
        select_address($(this).text(), address_type);
        return false;
    });
    show_location_select($('#select_location_link_'+address_type), address_type, 'address');
    $('#select_loc_'+address_type).hide();
    return false;
}

$(document).ready(function(){
    $('.find_box').remove();
	
    change_loc_selects('Origin', 0);
    change_loc_selects('Destination', 0);
    $('#ProgramOrigin').change(function(){hide_address_select('Origin')});
    $('#ProgramDestination').change(function(){hide_address_select('Destination')});
    
    $('.pop_close').click( function(){
        $(this).parents('.pop_location').fadeOut(200);
        return false;
    });

    $('.pop_close_word').click( function(){
        $(this).parents('.pop_location').fadeOut(200);
        return false;
    });
    var raw_cookie_values = getCookie('CakeCookie[search_data]');
    <?php if(!isset($submitted_data)){?>
    if(raw_cookie_values != ""){
        var cookie_values = jQuery.parseJSON(raw_cookie_values);
        for(cookie in cookie_values){
            cookie_type = cookie_values[cookie]['type'];
            cookie_value = cookie_values[cookie]['value'];
            if(cookie_type != 'input'){
                $('#'+cookie).prop("checked", cookie_value);
            }else{
                if(cookie == 'ProgramOrigin' || cookie == 'ProgramDestination'){
                    cookie_value = cookie_value.split("+").join(" ");
                }
                $('#'+cookie).val(cookie_value);
            }
        }
        submit_form(0);
    }else{
        submit_form(1);
    }
    <?php }else{?>
        submit_form(0);
    <?php }?>
});

function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){ 
            c_start=c_start + c_name.length+1; 
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}
</script>

<div class="cont_box_inside">
    <?php
    echo $this->Form->create('Program', array('action' => 'get_results_data', 'id' => 'ProgramIndexForm'));
    echo $this->Form->hidden('Location.origin', array('value' => ''));
    echo $this->Form->hidden('Location.destination', array('value' => ''));
    echo $this->Form->hidden('Address.origin', array('value' => ''));
    echo $this->Form->hidden('Address.destination', array('value' => ''));
    ?>
    <div id="select_address_Origin" class="pop_location">
        <div class="pop_arrow">arrow</div>
        <a href="#" class="pop_close">close</a>
        <div class="pop_title">Did you mean:</div>
        <ul class="select_address_ul"></ul>
    </div>
    <div id="select_address_Destination" class="pop_location">
        <div class="pop_arrow">arrow</div>
        <a href="#" class="pop_close">close</a>
        <div class="pop_title">Did you mean:</div>
        <ul class="select_address_ul"></ul>
    </div>
    <div class="sidebar">
    	<div id="search_public_transit">
        <p>Do you need public transits routes using bus, trolley, and/or rail?</p>
        <a href="/public-transit/">Search Public Transit</a>
        </div>
        <div id="map_wrapper" <?php if($hide_map){echo 'style="display:none;"';}?>>
            <div class="map"><?php echo $this->element('map');?></div>
            <div id="trip_duration"></div>
            <?php echo $this->Html->link('View larger map', array('controller' => 'programs', 'action' => 'map_route'), array('id' => 'map_route_link', 'class' => 'map_view', 'style' => 'display:none'));?><br />
            <?php echo $this->Html->link('View public transit routes', 'http://maps.google.com?f=d&dirflg=r', array('id' => 'map_pub_route_link', 'style' => 'display:none', 'class' => 'map_view', 'target' => '_blank'));?>
        </div>
        <div class="title_option">FILTER OPTIONS</div>
        <div class="side_block">
            <div class="side_title">Specific Services You Require</div>
            <?php $i = 1;foreach($services as $service_id => $service_label){?>
                <div class="side_row<?php echo ($i++ > 5 ? ' more_services" style="display:none;' : '');?>">
                    <?php echo $this->Form->input('Service.id.'.$service_id, array('type'=>'checkbox', 'class' => 'input_checkbox', 'label'=>$service_label, 'value' => $service_id));?>
                </div>
            <?php }?>
            <!--a href='#' class="btn_more" onClick="$('div.more_services').toggle();if($('div.more_services').is(':visible')){$(this).text('show less');}else{$(this).text('show more');}return false;">show more</a-->
        </div><!--end of side_block-->

        <div class="side_block">
            <div class="side_title">Fees</div>
            <?php //echo $this->Form->radio('Fee.fee', array(0 => 'Show All', 1 => 'No Fee', 2 => 'Flat Fare Under $5', 3 => 'Flat Fare $5 - $15', 4 => 'Other Fee Structure'), array('default' => 0, 'legend' => false, 'separator' => '</div><div class="side_row">', 'class' => 'input_radio'));?>
            <?php //echo $this->Form->radio('Fee.fee', array(0 => 'Show All', 1 => 'No Fee'), array('default' => 0, 'legend' => false, 'separator' => '</div><div class="side_row">', 'class' => 'input_radio'));?>
            <?php foreach(array(1 => 'Free', 2 => 'Fare Under $5', 5 => 'Fare $5 - $10', 0 => 'Show All') as $fee_id => $fee_op){?>
                <div class="side_row">
                    <?php echo $this->Form->input('Fee.fee.'.$fee_id, array('checked' => ($fee_id != 0 ? TRUE : FALSE), 'type'=>'checkbox', 'class' => 'input_checkbox', 'label'=>$fee_op, 'value' => $fee_id));?>
                </div>
            <?php }?>
        </div><!--end of side_block-->

        <div class="side_block">
            <div class="side_title">Eligibility Requirements</div>
            <div class="side_row">
            <?php echo $this->Form->radio('Eligibility.reqs', array(0 => 'Show All', 1 => 'Eligibility required', 2 => 'Open to public'), array('default' => 0, 'legend' => false, 'separator' => '</div><div class="side_row">', 'class' => 'input_radio'));?>
            </div>
        </div><!--end of side_block-->
    </div><!--end of sidebar-->

    <div class="main_content">
        <div class="path_box">
            <div class="path_form">
                <?php echo $this->element('zip_search_fields');?>
            </div>
        </div>
        <div id="content_for_update">
        </div>
    </div><!--end of main_content-->
</div>
<?php echo $this->Form->end();?>

<?php $this->Js->get('div.sidebar :input')->event('change', 'submit_form(1);');?>
<?php echo $this->Js->writeBuffer();?>