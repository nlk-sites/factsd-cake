<div class="programs index">
	<h2><?php echo __('Programs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('agency_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('advance_reservation');?></th>
			<th><?php echo $this->Paginator->sort('reservation_days');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_mon');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_tue');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_wed');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_thu');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_fri');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_sat');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_sun');?></th>
			<th><?php echo $this->Paginator->sort('open_hours_24_7');?></th>
			<th><?php echo $this->Paginator->sort('accept_insurance');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('contact_name');?></th>
			<th><?php echo $this->Paginator->sort('contact_title');?></th>
			<th><?php echo $this->Paginator->sort('contact_phone');?></th>
			<th><?php echo $this->Paginator->sort('contact_email');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('clients_only');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($programs as $program): ?>
	<tr>
		<td><?php echo h($program['Program']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($program['Agency']['name'], array('controller' => 'agencies', 'action' => 'view', $program['Agency']['id'])); ?>
		</td>
		<td><?php echo h($program['Program']['name']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['advance_reservation']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['reservation_days']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_mon']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_tue']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_wed']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_thu']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_fri']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_sat']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_sun']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['open_hours_24_7']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['accept_insurance']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['url']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['email']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['phone']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['contact_name']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['contact_title']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['contact_phone']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['contact_email']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['description']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['clients_only']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['created']); ?>&nbsp;</td>
		<td><?php echo h($program['Program']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $program['Program']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $program['Program']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $program['Program']['id']), null, __('Are you sure you want to delete # %s?', $program['Program']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Program'), array('action' => 'add')); ?></li>
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
