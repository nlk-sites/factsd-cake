<div class="agencies form">
    <?php echo $this->Form->create('Agency');?>
        <table class="form">
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        ID
                    </td>
                    <td class="form-data">
                        <?php echo $this->Form->value('Agency.id');?>
                        <?php echo $this->Form->input('Agency.id');?>
                    </td>
                </tr>
            <?php }?>
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Key
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.key', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Street Address<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.street1', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Street Address 2
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.street2', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    City<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.city', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    State<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.state', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Zip
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.zip', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Email
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.email', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        Phones
                    </td>
                    <td class="form-data" colspan="3">
                        <?php if(isset($phones) && !empty($phones)){?>
                            <table cellspacing="0" style="height:auto; width: auto; padding-bottom:5px;">
                                <?php foreach($phones as $p => $phone){?>
                                    <tr class="row-type-<?php echo $p+1 % 2;?>">
                                        <td>
                                            <?php if(!empty($phone['AgencyPhone']['phone']))echo $phone['AgencyPhone']['phone'];?>
                                        </td>
                                        <td>
                                            <?php if(!empty($phone['AgencyPhone']['type'])){?>
                                                <div style="padding-left: 30px;">
                                                    <b>Type</b>: <?php echo $phone['AgencyPhone']['type'];?>
                                                </div>
                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if(!empty($phone['AgencyPhone']['note'])){?>
                                                <div style="padding-left: 30px;">
                                                    <b>Note</b>: <?php echo $phone['AgencyPhone']['note'];?>
                                                </div>
                                            <?php }?>
                                        </td>
                                        <td style="padding-left:30px;">
                                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'agency_phones', 'action' => 'admin_edit', $phone['AgencyPhone']['id'])); ?> | 
                                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'agency_phones', 'action' => 'admin_delete', $phone['AgencyPhone']['id']), null, __('Are you sure you want to delete %s?', $phone['AgencyPhone']['phone'])); ?>
                                        </td>
                                    </tr>
                                <?php }?>
                            </table>
                        <?php }?>
                        <?php echo $this->Html->link(__('Add New Phone'), array('controller' => 'agency_phones', 'action' => 'admin_add', $agency_data['Agency']['id'])); ?>
                    </td>
                </tr>
            <?php }?>
            <tr>
                <td class="form-label">
                    URL
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.url', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Agency Type<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.agency_type_id', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Primary Service
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.primary_service', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Fax
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.fax', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Contact Name
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.contact_name', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Contact Title
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.contact_title', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Contact Phone
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.contact_phone', array('label' => FALSE, 'error' => FALSE));?>
                </td>
                <td class="form-label">
                    Contact Email
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Agency.contact_email', array('label' => FALSE, 'error' => FALSE));?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Description
                </td>
                <td class="form-data" colspan="3">
                    <?php echo $this->Form->input('Agency.description', array('label' => FALSE, 'error' => FALSE, 'style' => 'width: 100%;'));?>
                </td>
            </tr>
            <?php if($this->action == 'admin_edit'){?>
                <tr>
                    <td class="form-label">
                        Created On
                    </td>
                    <td class="form-data">
                        <?php echo date('F j, Y \a\t g:i a', strtotime($agency_data['Agency']['created']));?>
                    </td>
                    <td class="form-label">
                        Last Modified On
                    </td>
                    <td class="form-data">
                        <?php echo date('F j, Y \a\t g:i a', strtotime($agency_data['Agency']['modified']));?>
                    </td>
                </tr>
            <?php }?>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');
            if($user_level >= 1000){
                echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/agencies')."';"));
                if($this->action == 'admin_edit'){
                    echo $this->Html->link('Delete', '/admin/agencies/delete/'.$this->Form->value('Agency.id'), array('confirm' => 'Are you sure you want to delete this agency and all programs associated with it?  This cannot be undone.'));
                }
            }else{
                echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/programs')."';"));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>