<h2>Listing Cities</h2>
<br>
<?php if ($cities): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($cities as $city): ?>		<tr>

			<td><?php echo $city->name; ?></td>
			<td>
				<?php echo Html::anchor('cities/view/'.$city->id, 'View'); ?> |
				<?php echo Html::anchor('cities/edit/'.$city->id, 'Edit'); ?> |
				<?php echo Html::anchor('cities/delete/'.$city->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Cities.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('cities/create', 'Add new City', array('class' => 'btn success')); ?>

</p>
