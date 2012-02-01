<div class="reviews form">
    <?php echo $this->Form->create('Review'); ?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Review.name', array('label' => FALSE, 'error' => FALSE)); ?>
                    <?php echo $this->Form->input('Review.id');?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Approved<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Review.approved', array('label' => FALSE, 'error' => FALSE, 'type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'))); ?>
                </td>
                <td class="form-label">
                    Program<span class="required">*</span>
                </td>
                <td class="form-data">
                    <?php echo $this->Form->input('Program.id', array('label' => FALSE, 'error' => FALSE, 'type' => 'select', 'options' => $programs)); ?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Review<span class="required">*</span>
                </td>
                <td colspan="3" class="form-data">
                    <?php echo $this->Form->input('Review.review', array('label' => FALSE, 'error' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Created On
                </td>
                <td class="form-data">
                    <?php echo date('F j, Y \a\t g:i a', strtotime($review['Review']['created']));?>
                </td>
                <td class="form-label">
                    Last Modified On
                </td>
                <td class="form-data">
                    <?php echo date('F j, Y \a\t g:i a', strtotime($review['Review']['modified']));?>
                </td>
            </tr>
        </table>
        <p>
            <span class="required">* Required fields</span>
        </p>
        <div id="form-buttons">
            <?php echo $this->Form->submit('Save');?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/reviews')."';"));?>
            <?php if($this->action == 'admin_edit'){
                echo $this->Html->link('Delete', '/admin/reviews/delete/'.$this->Form->value('Review.id'), array('confirm' => 'Are you sure you want to delete this review?  This cannot be undone.'));
            }?>
        </div>
    <?php echo $this->Form->end();?>
</div>