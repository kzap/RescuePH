<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<?php echo Asset::js('jquery.ui.map.js') ?>

	
	<p>
<?php echo Form::open('rescue/') ?><?php echo Form::select('city_id', Input::post('city_id', isset($rescue) ? $rescue->city_id : ''), $cities, array('class' => 'span4')); ?>	<?php echo Form::submit('submit', "Sort", array('class'=>'btn')) ?> | <?php echo Html::anchor('rescue/create', 'Click here if someone you know needs rescuing', array('class' => 'btn success')); ?></form>

</p>



<script type="text/javascript">
	$(function()
	{
	// 	$("#map").gMap({ markers: [
	// 						<?php foreach ($lat as $r) {?>
 //                            { 
 //                            	latitide: <?php echo $r->lat ?>,
 //                            	longitude: <?php echo $r->lng ?>,
 //                              	html: "<strong><?php echo str_replace("\n"," ",$r->address) ?>, <?php echo $r->city->name ?></strong><br><?php echo str_replace("\n"," ",$r->specifics) ?>" 
 //                             },

 //                            <?php } ?>

 //                             ],
 //                  address: "Metro Manila, Philippines",
 //                  zoom: 9 });
	// });

	var jsondata = {"markers":[ 
						{ 	"latitude":57.7973333, 
							"longitude":12.0502107, 
							"title":"Angered", 
							"content":"Representing :)" 
						}, 
						{ "latitude":57.6969943, 
							"longitude":11.9865, 
							"title":"Gothenburg", 
							"content":"Swedens second largest city" 
						} 
						]};

<?php 
	if (Input::post('city_id'))
	{
		$city_id = Input::post('city_id');
	}else
	{
		$city_id = "";
	}
 ?>

$('#map_canvas').gmap().bind('init', function() { 
	// This URL won't work on your localhost, so you need to change it
	// see http://en.wikipedia.org/wiki/Same_origin_policy
	$.getJSON( 'http://rescueph.com/map/lat/'<?php echo $city_id ?>, function(data) { 
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

})
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

<div id="map_canvas" style="height:400px;">

</div>
<?php if (Input::post('city_id')): ?>
<h2><?php echo $city->name ?></h2>	
<?php endif ?>

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
				<strong><?php echo $rescue->city->name ?></strong>
			</td>
			<!-- <td><?php echo $rescue->city->name ?></td> -->
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
