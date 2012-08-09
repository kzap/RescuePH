<h2>Editing Status</h2>
<br>

<?php echo render('statuses/_form'); ?>
<p>
	<?php echo Html::anchor('statuses/view/'.$status->id, 'View'); ?> |
	<?php echo Html::anchor('statuses', 'Back'); ?></p>
