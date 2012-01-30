<style>
    .checkbox_td {width: 30px; text-align: center; /*border-bottom: solid #999999 1px;*/ padding: 1px 8px 1px 3px;}
    table.service {border: solid #999999 1px; margin-bottom: 10px;}
</style>
<?php echo $this->Form->create();?>
<table cellspacing="0" cellpadding="0" class="list service">
    <tr>
        <th class="checkbox_td"><input type="checkbox" class="checkall" /></th>
        <th>Service</th>
    </tr>
    <!--tr><td style="width:49%; border-right: 1px solid #999999;"><table cellspacing="0" cellpadding="0" id="reqs" class="list region" style="width: 100%;"-->
<?php 
$table_split = FALSE;
foreach($all_services as $si => $service){
    if(!$table_split && $si >= ($count_options/2)){
        $table_split = TRUE;?>
            <!--/table></td><td></td><td style="width:50%; border-right: 1px solid #999999;">
        <table cellspacing="0" cellpadding="0" id="reqs" class="list region" style="width: 100%;"-->
    <?php }?>
        <tr class="standalone row-type-<?php echo $si % 2;?>">
            <td class="checkbox_td">
                <?php echo $this->Form->input('ProgramsService.'.$service['Service']['id'].'.service_id', array('type' => 'checkbox', 'value' => $service['Service']['id'] , 'label' => FALSE));?>
            </td>
            <td colspan="3" style="text-align:left;">
                <?php echo $service['Service']['name'];?>
            </td>
        </tr>
<?php } ?>
        <!--/table></td></tr-->
</table>
<?php echo $this->Form->end('Save');?>
<?php ?>
<script>
$(document).ready(function () { // this line makes sure this code runs on page load
    $('.checkall').click(function () {
        var un = '';
        if(!this.checked){
            un = 'un';
        }
        if(confirm('This will ' + un + 'check all the checkboxes.  Is this what you want?')){
            $(this).parents('table:eq(0)').find(':checkbox').attr('checked', this.checked);
        }else{
            return false;
        }
    });
});
</script>