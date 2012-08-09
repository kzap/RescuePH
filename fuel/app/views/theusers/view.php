<h2>Viewing #<?php echo $theuser->id; ?></h2>

<p>
	<strong>Username:</strong>
	<?php echo $theuser->username; ?></p>
<p>
	<strong>Password:</strong>
	<?php echo $theuser->password; ?></p>
<p>
	<strong>Name:</strong>
	<?php echo $theuser->name; ?></p>

<?php echo Html::anchor('theusers/edit/'.$theuser->id, 'Edit'); ?> |
<?php echo Html::anchor('theusers', 'Back'); ?>