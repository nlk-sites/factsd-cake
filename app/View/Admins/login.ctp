<?php echo $this->Form->create('Admin', array('style' => 'height:80%;'));?>
<table id="" width="100%" height="100%" cellpadding="20" >
    <tr>
        <td valign="middle" align="center" style="height:100%;">
            <table style="width:auto;height:auto;">
                <tr>
                    <td align="center">
                        <h2>Administrator Login</h2>
                        <?php if ($this->Session->check('Message.flash')){?>
                            <div style="line-height:5px; padding-bottom: 15px; height:26px;">
                                <?php echo $this->Session->flash();?>
                            </div>
                        <?php }?>
                    </td>
                </tr>
            </table>
            <table align="center" id="login" style="width:auto;height:auto;">
                <tr>
                    <td class="form-label">Email:</td>
                    <td><?php echo $this->Form->input('email', array('error' => FALSE, 'label' => FALSE));?></td>
                </tr>
                <tr>
                    <td class="form-label">Password:</td>
                    <td><?php echo $this->Form->input('password', array('error' => FALSE, 'label' => FALSE));?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $this->Form->submit('Log in');?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php echo $this->Form->end();?>