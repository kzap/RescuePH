<p>
Please answer the following so that we can quickly place the information on the map. <br><br>

Please be as specific as you can: <br>
1. number of people in need of rescue <br>
2. level of flood in area (knee, waist, shoulder, etc) <br>
3. any info that might help rescuers <br> <br>

Messages are not limited to pleas for help, we also accept and encourage "situation updates" from different areas.
</p>

<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name (Name of Person/s in need of rescue)', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($rescue) ? $rescue->name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Street address of person/s in need of rescue', 'address'); ?>

			<div class="input">
				<?php echo Form::input('address', Input::post('address', isset($rescue) ? $rescue->address : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('City', 'city'); ?>

			<div class="input">
				<?php
				require_once(APPPATH . '/vendor/enthropia/class.form_generator.php');
				$form = new form_generator();
				echo $form->selectbox('city_id', (array) $citySelectOptions, 0, Input::post('city_id', isset($rescue) ? $rescue->city_id : ''), 'id="citySelect" class="span6"');
				?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo Form::label('Specifics - Other information (elderly, children, PWDs, special needs)', 'specifics'); ?>

			<div class="input">
				<?php echo Form::input('specifics', Input::post('specifics', isset($rescue) ? $rescue->specifics : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Reporter\'s name or Twitter @username', 'reporter'); ?>

			<div class="input">
				<?php echo Form::input('reporter', Input::post('reporter', isset($rescue) ? $rescue->reporter : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Source - Tweet URL or FB status link', 'source'); ?>

			<div class="input">
				<?php echo Form::input('source', Input::post('source', isset($rescue) ? $rescue->source : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Status', 'status_id'); ?>

			<div class="input">
				<?php echo Form::select('status_id', Input::post('status_id', isset($rescue) ? $rescue->status_id : ''), $statuses, array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>