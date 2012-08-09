<h2>Viewing #<?php echo $city->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $city->name; ?></p>

<?php echo Html::anchor('cities/edit/'.$city->id, 'Edit'); ?> |
<?php echo Html::anchor('cities', 'Back'); ?>