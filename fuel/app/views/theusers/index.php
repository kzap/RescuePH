<h2>Listing Theusers</h2>
<br>
<?php if ($theusers): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Username</th>
			<th>Password</th>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($theusers as $theuser): ?>		<tr>

			<td><?php echo $theuser->username; ?></td>
			<td><?php echo $theuser->password; ?></td>
			<td><?php echo $theuser->name; ?></td>
			<td>
				<?php echo Html::anchor('theusers/view/'.$theuser->id, 'View'); ?> |
				<?php echo Html::anchor('theusers/edit/'.$theuser->id, 'Edit'); ?> |
				<?php echo Html::anchor('theusers/delete/'.$theuser->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Theusers.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('theusers/create', 'Add new Theuser', array('class' => 'btn success')); ?>

</p>
