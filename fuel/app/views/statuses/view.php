<h2>Viewing #<?php echo $status->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $status->name; ?></p>

<?php echo Html::anchor('statuses/edit/'.$status->id, 'Edit'); ?> |
<?php echo Html::anchor('statuses', 'Back'); ?>