<h2>Listing Logins</h2>
<br>
<?php if ($logins): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Username</th>
			<th>Password</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($logins as $login): ?>		<tr>

			<td><?php echo $login->username; ?></td>
			<td><?php echo $login->password; ?></td>
			<td>
				<?php echo Html::anchor('login/view/'.$login->id, 'View'); ?> |
				<?php echo Html::anchor('login/edit/'.$login->id, 'Edit'); ?> |
				<?php echo Html::anchor('login/delete/'.$login->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Logins.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('login/create', 'Add new Login', array('class' => 'btn success')); ?>

</p>
