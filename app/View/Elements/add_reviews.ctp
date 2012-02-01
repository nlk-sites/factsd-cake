<?php echo $this->Form->create('Review', array('controller' => 'reviews', 'action' => 'add', 'class' => 'review_form'));?>
    <fieldset>
        <div class="review_title">Write a review</div>
        <?php echo $this->Form->hidden('Review.program_id', array('value' => $program_id));?>
        <?php echo $this->Form->input('Review.name', array('div' => FALSE, 'label' => 'Your Name', 'class' => 'input_txt', 'error' => FALSE));?>
        <?php echo $this->Form->input('Review.review', array('div' => FALSE, 'label' => 'Your Review', 'cols' => FALSE, 'rows' => FALSE, 'error' => FALSE));?>
        <?php echo $this->Js->submit('Submit', array('div' => FALSE, 'class' => 'input_submit', 'update' => '#ReviewAddForm', 'url' => array('controller' => 'reviews', 'action' => 'add')));?>
    </fieldset>
    <?php echo $this->Session->flash();?>
<?php echo $this->Form->end();?>