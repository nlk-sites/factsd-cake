<style>
    .checkbox_td {width: 30px; text-align: center; border-bottom: solid #999999 1px; padding: 1px 8px 1px 3px;}
    .area_name_td {/*width: 25%;*/ border-bottom: solid #999999 1px; border-right: solid #999999 1px;}
    table.region {border: solid #999999 1px; margin-bottom: 10px; border-bottom: none; border-right: none;}
    tr.standalone, tr.standalone th {background-color:#EBEBEB; }
    
    tr.mini td {
        border-bottom: 1px solid #E6E6E6;
        border-right: none;
    }
    tr.mini td.mini-0 {
        border-right: 1px solid #E6E6E6;
    }
</style>
<?php echo $this->Form->create();?>
<table cellspacing="0" cellpadding="0" style="width: 98%;">
    <tr><td style="width:49%; border-right: 1px solid #999999;"><table cellspacing="0" cellpadding="0" id="reqs" class="list region" style="width: 100%;">
<?php 
$table_split = FALSE;
$ri = 0;
foreach($req_options as $req){
    if(!$table_split && $ri >= ($count_options/2)){
        $table_split = TRUE;?>
            </table></td><td></td><td style="width:50%; border-right: 1px solid #999999;">
        <table cellspacing="0" cellpadding="0" id="reqs" class="list region" style="width: 100%;">
    <?php }
    $ri += count($req['EligReqOption']);
    if(count($req['EligReqOption']) == 1 && ($req['EligReqOption'][0]['name'] == 'Yes' || $req['EligReqOption'][0]['name'] == '')){?>
        <tr class="standalone">
            <th class="checkbox_td">
                <?php echo $this->Form->input('EligReqOptionsProgram.'.$req['EligReqOption'][0]['id'].'.elig_req_option_id', array('type' => 'checkbox','value' => $req['EligReqOption'][0]['id'] , 'label' => FALSE));?>
            </th>
            <th colspan="3" style="text-align:left;">
                <?php echo $req['EligReq']['name'];?>
            </th>
        </tr>
    <?php }elseif(count($req['EligReqOption']) > 1){ $ri++;?>
        <tr>
            <th class="checkbox_td"></th>
            <th colspan="3" style="text-align:left;"><?php echo $req['EligReq']['name'];?></th>
        </tr>
        <?php foreach($req['EligReqOption'] as $i => $option){?>
            <?php if($i % 2 == 0){?>
                <tr class="mini">
            <?php }?>
        <!--tr class="mini"-->
                <td class="checkbox_td">
                    <?php echo $this->Form->input('EligReqOptionsProgram.'.$option['id'].'.elig_req_option_id', array('type' => 'checkbox', 'value' => $option['id'], 'label' => FALSE));?>
                </td>
                <td class="area_name_td mini-<?php echo $i % 2;?>">
                    <?php echo $option['name'];?>
                </td>
            <?php if($i % 2 == 1 || $option == end($req['EligReqOption'])){?>
                </tr>
            <?php }?>
                <!--/tr-->
        <?php }?>
    <?php }?>
<?php } ?>
        </table></td></tr>
</table>
<?php echo $this->Form->end('Save');?>
<?php ?>