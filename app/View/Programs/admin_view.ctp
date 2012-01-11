<div class="programs view">
<h2><?php  echo __('Program');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($program['Program']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Agency'); ?></dt>
		<dd>
			<?php echo $this->Html->link($program['Agency']['name'], array('controller' => 'agencies', 'action' => 'view', $program['Agency']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($program['Program']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Advance Reservation'); ?></dt>
		<dd>
			<?php echo h($program['Program']['advance_reservation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reservation Days'); ?></dt>
		<dd>
			<?php echo h($program['Program']['reservation_days']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Mon'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_mon']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Tue'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_tue']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Wed'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_wed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Thu'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_thu']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Fri'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_fri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Sat'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_sat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours Sun'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_sun']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Open Hours 24 7'); ?></dt>
		<dd>
			<?php echo h($program['Program']['open_hours_24_7']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accept Insurance'); ?></dt>
		<dd>
			<?php echo h($program['Program']['accept_insurance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($program['Program']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($program['Program']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($program['Program']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Name'); ?></dt>
		<dd>
			<?php echo h($program['Program']['contact_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Title'); ?></dt>
		<dd>
			<?php echo h($program['Program']['contact_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Phone'); ?></dt>
		<dd>
			<?php echo h($program['Program']['contact_phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Email'); ?></dt>
		<dd>
			<?php echo h($program['Program']['contact_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($program['Program']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clients Only'); ?></dt>
		<dd>
			<?php echo h($program['Program']['clients_only']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($program['Program']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($program['Program']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Program'), array('action' => 'edit', $program['Program']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Program'), array('action' => 'delete', $program['Program']['id']), null, __('Are you sure you want to delete # %s?', $program['Program']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Programs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program'), array('action' => 'add')); ?> </li>
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
	<div class="related">
		<h3><?php echo __('Related Fees');?></h3>
	<?php if (!empty($program['Fee'])):?>
		<dl>
			<dt><?php echo __('Id');?></dt>
		<dd>
	<?php echo $program['Fee']['id'];?>
&nbsp;</dd>
		<dt><?php echo __('Program Id');?></dt>
		<dd>
	<?php echo $program['Fee']['program_id'];?>
&nbsp;</dd>
		<dt><?php echo __('Fee');?></dt>
		<dd>
	<?php echo $program['Fee']['fee'];?>
&nbsp;</dd>
		<dt><?php echo __('Description');?></dt>
		<dd>
	<?php echo $program['Fee']['description'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Fee'), array('controller' => 'fees', 'action' => 'edit', $program['Fee']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php echo __('Related Program Dest Zips');?></h3>
	<?php if (!empty($program['ProgramDestZip'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Program Id'); ?></th>
		<th><?php echo __('Zip Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($program['ProgramDestZip'] as $programDestZip): ?>
		<tr>
			<td><?php echo $programDestZip['id'];?></td>
			<td><?php echo $programDestZip['program_id'];?></td>
			<td><?php echo $programDestZip['zip_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'program_dest_zips', 'action' => 'view', $programDestZip['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'program_dest_zips', 'action' => 'edit', $programDestZip['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'program_dest_zips', 'action' => 'delete', $programDestZip['id']), null, __('Are you sure you want to delete # %s?', $programDestZip['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Program Dest Zip'), array('controller' => 'program_dest_zips', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Program Orig Zips');?></h3>
	<?php if (!empty($program['ProgramOrigZip'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Program Id'); ?></th>
		<th><?php echo __('Zip Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($program['ProgramOrigZip'] as $programOrigZip): ?>
		<tr>
			<td><?php echo $programOrigZip['id'];?></td>
			<td><?php echo $programOrigZip['program_id'];?></td>
			<td><?php echo $programOrigZip['zip_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'program_orig_zips', 'action' => 'view', $programOrigZip['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'program_orig_zips', 'action' => 'edit', $programOrigZip['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'program_orig_zips', 'action' => 'delete', $programOrigZip['id']), null, __('Are you sure you want to delete # %s?', $programOrigZip['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Program Orig Zip'), array('controller' => 'program_orig_zips', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Elig Req Options');?></h3>
	<?php if (!empty($program['EligReqOption'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Elig Req Id'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Min'); ?></th>
		<th><?php echo __('Max'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($program['EligReqOption'] as $eligReqOption): ?>
		<tr>
			<td><?php echo $eligReqOption['id'];?></td>
			<td><?php echo $eligReqOption['elig_req_id'];?></td>
			<td><?php echo $eligReqOption['weight'];?></td>
			<td><?php echo $eligReqOption['name'];?></td>
			<td><?php echo $eligReqOption['min'];?></td>
			<td><?php echo $eligReqOption['max'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'elig_req_options', 'action' => 'view', $eligReqOption['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'elig_req_options', 'action' => 'edit', $eligReqOption['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'elig_req_options', 'action' => 'delete', $eligReqOption['id']), null, __('Are you sure you want to delete # %s?', $eligReqOption['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Elig Req Option'), array('controller' => 'elig_req_options', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Search Requests');?></h3>
	<?php if (!empty($program['SearchRequest'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Session Id'); ?></th>
		<th><?php echo __('Orig Zip'); ?></th>
		<th><?php echo __('Orig City'); ?></th>
		<th><?php echo __('Orig Zip Alias Id'); ?></th>
		<th><?php echo __('Dest Zip'); ?></th>
		<th><?php echo __('Dest City'); ?></th>
		<th><?php echo __('Dest Zip Alias Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($program['SearchRequest'] as $searchRequest): ?>
		<tr>
			<td><?php echo $searchRequest['id'];?></td>
			<td><?php echo $searchRequest['session_id'];?></td>
			<td><?php echo $searchRequest['orig_zip'];?></td>
			<td><?php echo $searchRequest['orig_city'];?></td>
			<td><?php echo $searchRequest['orig_zip_alias_id'];?></td>
			<td><?php echo $searchRequest['dest_zip'];?></td>
			<td><?php echo $searchRequest['dest_city'];?></td>
			<td><?php echo $searchRequest['dest_zip_alias_id'];?></td>
			<td><?php echo $searchRequest['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'search_requests', 'action' => 'view', $searchRequest['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'search_requests', 'action' => 'edit', $searchRequest['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'search_requests', 'action' => 'delete', $searchRequest['id']), null, __('Are you sure you want to delete # %s?', $searchRequest['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Search Request'), array('controller' => 'search_requests', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Services');?></h3>
	<?php if (!empty($program['Service'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($program['Service'] as $service): ?>
		<tr>
			<td><?php echo $service['id'];?></td>
			<td><?php echo $service['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'services', 'action' => 'view', $service['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'services', 'action' => 'edit', $service['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'services', 'action' => 'delete', $service['id']), null, __('Are you sure you want to delete # %s?', $service['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Service'), array('controller' => 'services', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
