<h2>Editing Rescue</h2>
<br>

<?php echo render('rescue/_form'); ?>
<p>
	<?php echo Html::anchor('rescue/view/'.$rescue->id, 'View'); ?> |
	<?php echo Html::anchor('rescue', 'Back'); ?></p>
