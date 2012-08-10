<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true&region=Metro+Manila"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<?php echo Asset::js('jquery.ui.map.js') ?>

	
	<p>
<?php
require_once(APPPATH . '/vendor/enthropia/class.form_generator.php');
$form = new form_generator();
echo $form->open('areaFilter', 'POST', '/', 'id="areaFilter"');
echo $form->selectbox('areaSelect', (array) $areaSelectOptions, 0, Input::post('areaSelect'), 'id="areaSelect" class="span4"');
echo $form->selectbox('areaCitySelect', (array) $areaCitySelectOptions, 0, Input::post('areaCitySelect'), 'id="areaCitySelect" class="span4" style="' . (!empty($areaCitySelectOptions) ? '' : 'display: none;') . '"');
echo $form->submit('submit', 'View', 'class="btn"');
echo '&nbsp;|&nbsp;';
echo Html::anchor('rescue/create', 'Click here if someone you know needs rescuing', array('class' => 'btn success'));
echo $form->close();
?>
</p>

<script type="text/javascript">
$(function() {

	$('#map_canvas').gmap().bind('init', function() { 
		// This URL won't work on your localhost, so you need to change it
		// see http://en.wikipedia.org/wiki/Same_origin_policy
		$.getJSON( '/map/lat/<?php echo (Input::post('areaCitySelect', false) ? Input::post('areaCitySelect', '') : Input::post('areaSelect', '')); ?>', function(data) { 
			$.each( data.markers, function(i, marker) {
				$('#map_canvas').gmap('addMarker', { 
					'position': new google.maps.LatLng(marker.latitude, marker.longitude), 
					'bounds': true 
				}).click(function() {
					$('#map_canvas').gmap('openInfoWindow', { 'content': marker.content }, this);
				});
			});
		});
	});

});
</script>

<style type="text/css">
	.red 
	{
		color: red;
	}
	.blue
	{
		color: blue;
	}
	.green
	{
		color:green;
	}
</style>
<?php
if (!empty($rescues)) { echo '<div id="map_canvas" style="height:400px;"></div>'; }

if (!empty($cityInfo)) { echo '<h2>' . $cityInfo->city_region_name . '</h2>'; }
elseif (!empty($regionInfo)) { echo '<h2>' . $regionInfo->region_name . '</h2>'; }
?>

<br>

<?php if ($rescues): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<!-- <th>City id</th> -->
			<th>Specifics</th>
			<!-- <th>Reporter</th> -->
			<!-- <th>Source</th> -->
			<th>Status id</th>
			<!-- <th></th> -->
		</tr>
	</thead>
	<tbody>
<?php foreach ($rescues as $rescue): ?>		<tr>

			<td><?php echo $rescue->name; ?></td>
			<td><?php echo $rescue->address; ?><br>
				<strong><?php echo $rescue->GeoCityNames->city_region_name ?></strong>
			</td>
			<td><?php echo $rescue->specifics; ?><br>
				<strong>by: <?php echo $rescue->reporter; ?></strong><br>
				<!-- <strong>source: <?php echo $rescue->source; ?></strong></td> -->
			<!-- <td><?php echo $rescue->reporter; ?></td> -->
			<!-- <td><?php echo $rescue->source; ?></td> -->
			<td>
				<span class="<?php if ($rescue->status_id == 1): ?>red
				<?php elseif ($rescue->status->id == 2): ?>
					blue
				<?php else: ?>
					green
				<?php endif ?>"><?php echo $rescue->status->name; ?></span></td>
			<!-- <td>
				<?php echo Html::anchor('rescue/view/'.$rescue->id, 'View'); ?> |
				<?php echo Html::anchor('rescue/edit/'.$rescue->id, 'Edit'); ?> |
				<?php echo Html::anchor('rescue/delete/'.$rescue->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td> -->
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Rescues.</p>

<?php endif; ?>
