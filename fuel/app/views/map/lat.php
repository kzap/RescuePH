
{"markers":<?php 
$ar = 0;
$markers = array();
foreach ($lat as $l) {
	$markers[$ar]['latitude'] = $l->lat;
	$markers[$ar]['longitude'] = $l->lng;
	$markers[$ar]['title'] = $l->address. ", ". $l->city->name;
	$markers[$ar]['content'] = "<strong>". $l->address . ", ". $l->city->name. " </strong> - ". $l->specifics;
	$ar ++;

}

// print_r($markers);
// exit;

echo json_encode($markers);
	 ?>}