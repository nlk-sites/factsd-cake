<div class="programs form">
<?php echo $this->Form->create('Program');?>
	<fieldset>
		<legend><?php echo __('Add Program'); ?></legend>
	<?php
		echo $this->Form->input('agency_id');
		echo $this->Form->input('name');
		echo $this->Form->input('advance_reservation');
		echo $this->Form->input('reservation_days');
		echo $this->Form->input('open_hours_mon');
		echo $this->Form->input('open_hours_tue');
		echo $this->Form->input('open_hours_wed');
		echo $this->Form->input('open_hours_thu');
		echo $this->Form->input('open_hours_fri');
		echo $this->Form->input('open_hours_sat');
		echo $this->Form->input('open_hours_sun');
		echo $this->Form->input('open_hours_24_7');
		echo $this->Form->input('accept_insurance');
		echo $this->Form->input('url');
		echo $this->Form->input('email');
		echo $this->Form->input('phone');
		echo $this->Form->input('contact_name');
		echo $this->Form->input('contact_title');
		echo $this->Form->input('contact_phone');
		echo $this->Form->input('contact_email');
		echo $this->Form->input('description');
		echo $this->Form->input('clients_only');
		echo $this->Form->input('EligReqOption');
		echo $this->Form->input('SearchRequest');
		echo $this->Form->input('Service');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Programs'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Agencies'), array('controller' => 'agencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Agency'), array('controller' => 'agencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fees'), array('controller' => 'fees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fee'), array('controller' => 'fees', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Dest Zips'), array('controller' => 'program_dest_zips', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Dest Zip'), array('controller' => 'program_dest_zips', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Orig Zips'), array('controller' => 'program_orig_zips', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Orig Zip'), array('controller' => 'program_orig_zips', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Elig Req Options'), array('controller' => 'elig_req_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Elig Req Option'), array('controller' => 'elig_req_options', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Search Requests'), array('controller' => 'search_requests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Search Request'), array('controller' => 'search_requests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Services'), array('controller' => 'services', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Service'), array('controller' => 'services', 'action' => 'add')); ?> </li>
	</ul>
</div>
