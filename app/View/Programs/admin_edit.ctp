<div class="programs form">
    <?php echo $this->Form->create('Program');?>
        <table class="form">
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        ID
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->value('Program.id');?>
                        <?php echo $this->Form->input('Program.id');?>
                    </td>
                </tr>
            <?php }?>
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            <?php if($user_level >= 1000){?>
                    <td class="form-label">
                        Agency<span class="required">*</span>
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->input('Program.agency_id', array('label' => FALSE, 'error' => FALSE));?>
                    </td>
            <?php }?>
            </tr>
            <tr>
                <td class="form-label">
                    Advance Reservation<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.advance_reservation', array('label' => FALSE, 'error' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes')));?>
                </td>
                <td class="form-label">
                    Reservation Days
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.reservation_days', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Open Hours Monday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_mon', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Open Hours Tuesday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_tue', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Open Hours Wednesday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_wed', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Open Hours Thursday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_thu', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Open Hours Friday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_fri', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Open Hours Saturday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_sat', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Open Hours Sunday
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_sun', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Open Hours 24/7<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.open_hours_24_7', array('label' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'), 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Accepts Insurance<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.accept_insurance', array('label' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'), 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    URL
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.url', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Email
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.email', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Phone
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.phone', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Contact Name
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.contact_name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Contact Title
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.contact_title', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Contact Phone
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.contact_phone', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Contact Email
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.contact_email', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Clients Only
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.clients_only', array('label' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'), 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Description
                </td>
                <td colspan="3" class="form-data">
                    <?php echo $this->Form->input('Program.description', array('label' => FALSE, 'style' => 'width:100%;', 'error' => FALSE));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/programs')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/programs/delete/'.$this->Form->value('Program.id'), array('confirm' => 'Are you sure you want to delete this program?  This cannot be undone.'));
            }elseif($user_level < 1000){
                echo $this->Form->hidden('Program.agency_id');
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>