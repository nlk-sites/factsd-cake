<div class="admins form">
    <?php echo $this->Form->create('Admin');?>
        <table class="form">
            <tr>
                <td class="form-label" style="width:150px;">
                    First Name<span class="required">*</span>
                </td>
                <td class="form-data" style="width:35%">
                    <?php echo $this->Form->input('Admin.first_name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label" style="width:150px;">
                    Last Name<span class="required">*</span>
                </td>
                <td class="form-data" style="width:35%">
                    <?php echo $this->Form->input('Admin.last_name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Email<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Admin.email', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    New Password
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Admin.password', array('label' => FALSE, 'error' => FALSE, 'type' => 'password'));?>
                </td>
                <td class="form-label">
                    Re-enter Password
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Admin.password2', array('label' => FALSE, 'error' => FALSE, 'type' => 'password'));?>
                </td>
            </tr>
            <?php if($user_level >= 2000){?>
                <tr>
                    <td class="form-label">
                        Active<span class="required">*</span>
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->input('Admin.active', array('label' => FALSE, 'error' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes')));?>
                    </td>
                    <td class="form-label">
                        Permissions Level<span class="required">*</span>
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->input('Admin.user_level_id', array('label' => FALSE, 'error' => FALSE));?>
                    </td>
                </tr>
                <tr id="agency_tr" style="display:none;">
                    <td class="form-label">
                        Agency<span class="required">*</span>
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->input('Admin.agency_id', array('label' => FALSE, 'error' => FALSE, 'empty' => TRUE));?>
                    </td>
                </tr>
            <?php }?>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/admins')."';"));?>
            <?php if($this->action == 'admin_edit'){
                if($user_level >= 2000){
                    echo $this->Html->link('Delete', '/admin/admins/delete/'.$this->Form->value('Admin.id'), array('confirm' => 'Are you sure you want to delete this user?  This cannot be undone.'));
                }
                echo $this->Form->input('Admin.id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>
<script>
    $(document).ready(function(){
        $('#AdminUserLevelId').change(function(){
            if($(this).val() == 500){
                $('#agency_tr').show();
            }else{
                $('#agency_tr').hide();
            }
        }).change();
        
    });
</script>