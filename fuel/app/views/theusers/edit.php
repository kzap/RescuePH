<h2>Editing Theuser</h2>
<br>

<?php echo render('theusers/_form'); ?>
<p>
	<?php echo Html::anchor('theusers/view/'.$theuser->id, 'View'); ?> |
	<?php echo Html::anchor('theusers', 'Back'); ?></p>
