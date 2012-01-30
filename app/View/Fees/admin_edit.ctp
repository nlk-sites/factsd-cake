<div class="fees form">
    <?php echo $this->Form->create('Fee');?>
        <table class="form">
            <tr>
                <td class="form-label" style="width:100px;">
                    Fee Type<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('fee_type_id', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr id="fee-tr">
                <td class="form-label">
                    Fee<span class="required">*</span>
                </td>
                <td class="form-data">
                    <div id="normal-fee-div">
                        $<?php echo $this->Form->input('fee', array('label' => FALSE, 'maxchars' => 9, 'style' => 'width: 50px;', 'error' => FALSE));?>
                        <div id="fee-type-7">
                            per hour
                        </div>
                        <div id="fee-type-8">
                            for the first <?php echo $this->Form->input('miles_included', array('label' => FALSE, 'maxchars' => 4, 'style' => 'width: 50px;', 'error' => FALSE));?> miles, and then $<?php echo $this->Form->input('per_mile', array('label' => FALSE, 'maxchars' => 9, 'style' => 'width: 50px;', 'error' => FALSE));?> per mile.
                        </div>
                    </div>
                    <div id="misc-fee-div">
                        <?php echo $this->Form->input('misc_fee', array('label' => FALSE, 'error' => FALSE, 'maxchars' => 255, 'style' => 'width: 100%;'));?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Description
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('description', array('label' => FALSE, 'style' => 'width:100%;', 'error' => FALSE));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/fees/index/'.$program_info['Program']['id'])."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/fees/delete/'.$this->Form->value('Fee.id'), array('confirm' => 'Are you sure you want to delete this fee?  This cannot be undone.'));
                echo $this->Form->input('Fee.id');
            }else{
                echo $this->Form->hidden('program_id', array('value' => $program_info['Program']['id']));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>
<script>
    $('#FeeFeeTypeId').change(function(){
        var fee_type = $('#FeeFeeTypeId').val();
        if(fee_type == 9){
            $('#fee-tr').hide();
        }else{
            $('#fee-tr').show();
            if(fee_type == 10){
                $('#normal-fee-div').hide();
                $('#misc-fee-div').show();
            }else{
                $('#misc-fee-div').hide();
                $('#fee-tr').show();
                $('#normal-fee-div').show();
                if(fee_type == 7){
                    $('#fee-type-7').show();
                    $('#fee-type-8').hide();
                }else if(fee_type == 8){
                    $('#fee-type-7').hide();
                    $('#fee-type-8').show();
                }else{
                    $('#fee-type-7').hide();
                    $('#fee-type-8').hide();
                }
            }
        }
    });
    
    $(document).ready(function(){
        $('#FeeFeeTypeId').change();
    });
</script>