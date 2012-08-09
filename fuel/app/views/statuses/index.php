<h2>Listing Statuses</h2>
<br>
<?php if ($statuses): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($statuses as $status): ?>		<tr>

			<td><?php echo $status->name; ?></td>
			<td>
				<?php echo Html::anchor('statuses/view/'.$status->id, 'View'); ?> |
				<?php echo Html::anchor('statuses/edit/'.$status->id, 'Edit'); ?> |
				<?php echo Html::anchor('statuses/delete/'.$status->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Statuses.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('statuses/create', 'Add new Status', array('class' => 'btn success')); ?>

</p>
