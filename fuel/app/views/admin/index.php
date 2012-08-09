<p>
<?php echo Form::open('admin/') ?><?php echo Form::select('city_id', Input::post('city_id', isset($rescue) ? $rescue->city_id : ''), $cities, array('class' => 'span4')); ?>	<?php echo Form::select('status_id', Input::post('status_id', isset($rescue) ? $rescue->status_id : ''), $statuses, array('class' => 'span4')); ?> <?php echo Form::submit('submit', "Sort", array('class'=>'btn')) ?> | <?php echo Html::anchor('rescue/create', 'New Rescue Request', array('class' => 'btn success')); ?></form>

</p>


</div>
<h2><?php if (Input::post('city_id')): ?>
<?php echo $city->name ?>
<?php endif ?>
<?php if (Input::post('status_id')): ?>
	<?php echo $status->name ?>
<?php endif ?>
</h2>
<br>
<?php if ($rescues): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th>City id</th>
			<th>Specifics</th>
			<th>Reporter</th>
			<th>Source</th>
			<th>Status id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($rescues as $rescue): ?>		<tr>

			<td><?php echo $rescue->name; ?></td>
			<td><?php echo $rescue->address; ?></td>
			<td><?php echo $rescue->city->name; ?></td>
			<td><?php echo $rescue->specifics; ?></td>
			<td><?php echo $rescue->reporter; ?></td>
			<td><?php echo $rescue->source; ?></td>
			<td>
				<span class="<?php if ($rescue->status_id == 1): ?>red
				<?php elseif ($rescue->status->id == 2): ?>
					blue
				<?php else: ?>
					green
				<?php endif ?>"><?php echo $rescue->status->name; ?></span></td>
			<td><?php echo $rescue->theuser->name ?></td>
			<td style="font-size:10px">
				<?php echo Html::anchor('admin/edit/'.$rescue->id, 'Update status'); ?> |
				<?php echo Html::anchor('admin/delete/'.$rescue->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Rescues.</p>

<?php endif; ?>
