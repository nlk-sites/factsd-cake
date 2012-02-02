<div class="reviews form">
    <?php echo $this->Form->create('Review'); ?>
        <table class="form">
            <tr>
                <td class="form-label">
                    Name
                </td>
                <td class="form-data">
                    <?php echo $review['Review']['name']; ?>
                    <?php echo $this->Form->input('Review.id');?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Approved
                </td>
                <td class="form-data">
                    <?php echo ($review['Review']['approved'] == 1 ? 'Yes' : 'No'); ?>
                </td>
                <td class="form-label">
                    Program
                </td>
                <td class="form-data">
                    <?php echo $review['Program']['name']; ?>
                </td>
            </tr>
            <tr>
                <td class="form-label">
                    Review
                </td>
                <td colspan="3" class="form-data">
                    <?php echo strip_tags($review['Review']['review']);?>
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
        </p>
        <div id="form-buttons">
            <?php if($review['Review']['approved'] == 0){
                echo $this->Form->button('Approve Comment', array('type' => 'button', 'onClick' => "if(confirm('Are you sure you want to approve this review?')){location.href='".$this->Html->url('/admin/reviews/approve/1/'.$review['Review']['id'])."';}"));
            }else{
                echo $this->Form->button('Un-Approve Comment', array('type' => 'button', 'onClick' => "if(confirm('Are you sure you want to un-approve this review?')){location.href='".$this->Html->url('/admin/reviews/approve/0/'.$review['Review']['id'])."';}"));
            }?>
            <?php echo $this->Form->button('Cancel', array('type' => 'button', 'onClick' => "location.href='".$this->Html->url('/admin/reviews')."';"));?>
            <?php echo $this->Html->link('Delete', '/admin/reviews/delete/'.$review['Review']['id'], array('confirm' => 'Are you sure you want to delete this review?  This cannot be undone.'));?>
        </div>
    <?php echo $this->Form->end();?>
</div>