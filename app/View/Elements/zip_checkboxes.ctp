<style>
    .checkbox_td {width: 30px; text-align: center; border-bottom: solid #999999 1px; padding: 1px 8px 1px 3px;}
    .area_name_td {width: 25%; border-bottom: solid #999999 1px; border-right: solid #999999 1px;}
    table.region {border: solid #999999 1px; margin-bottom: 10px; border-bottom: none; border-right: none;}
</style>
<?php $region = '';
$z_i = 0;?>
<?php foreach($zips as $z){
    if($z['Zip']['region_id'] != $region){?>
        <?php if(isset($region_num)){
            if($region_num % 4 != 1){?>
                </tr>
            <?php }?>
            </table>
        <?php }?>
        <table cellspacing="0" cellpadding="0" id="region-<?php echo $z['Zip']['region_id'];?>" class="list region">
            <tr>
                <th class="checkbox_td"><input type="checkbox" class="checkall" /></th>
                <th colspan="11"><?php echo $z['Region']['name'];?></th>
            </tr>
        <?php $region = $z['Zip']['region_id'];
        $region_num = 1;
    }?>
    <?php if($region_num % 4 == 1){?>
        <tr class="row-type-1">
    <?php }?>
        <td class="checkbox_td">
            <?php echo $this->Form->input($zip_model.'.'.$z['Zip']['id'], array('hiddenField' => FALSE, 'type' => 'checkbox', 'label' => FALSE, 'value' => $z['Zip']['id']));?>
        </td>
        <td class="checkbox_td">
            <?php echo $z['Zip']['id'];?>
        </td>
        <td class="area_name_td">
            <?php echo $z['Zip']['area_name'];?>
        </td>
    <?php if(!$region_num++ % 4){?>
        </tr>
    <?php }?>
<?php } ?>
</table>
<script>
function set_background(el, checked){
    if(checked){
        color = '#CCDAFF';
    }else{
        color = 'white';
    }
    el.closest('td').css('background-color', color).next().css('background-color', color).next().css('background-color', color);
}
$(document).ready(function () { // this line makes sure this code runs on page load
    $('.checkall').click(function () {
        var un = '';
        if(!this.checked){
            un = 'un';
        }
        if(confirm('This will ' + un + 'check all the checkboxes in this region.  Is this what you want?')){
            $(this).parents('table:eq(0)').find(':checkbox').attr('checked', this.checked);
        }else{
            return false;
        }
    });
    $('input:checkbox:checked').each(function(){
        set_background($(this), true);
    });
    $('input:checkbox').change(function(){
        set_background($(this), $(this).is(':checked'));
    });
});
</script>