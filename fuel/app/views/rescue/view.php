<h2>Viewing #<?php echo $rescue->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $rescue->name; ?></p>
<p>
	<strong>Address:</strong>
	<?php echo $rescue->address; ?></p>
<p>
	<strong>City id:</strong>
	<?php echo $rescue->city_id; ?></p>
<p>
	<strong>Specifics:</strong>
	<?php echo $rescue->specifics; ?></p>
<p>
	<strong>Reporter:</strong>
	<?php echo $rescue->reporter; ?></p>
<p>
	<strong>Source:</strong>
	<?php echo $rescue->source; ?></p>
<p>
	<strong>Status id:</strong>
	<?php echo $rescue->status_id; ?></p>

<?php echo Html::anchor('rescue/edit/'.$rescue->id, 'Edit'); ?> |
<?php echo Html::anchor('rescue', 'Back'); ?>