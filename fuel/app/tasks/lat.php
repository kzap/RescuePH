<?php

namespace Fuel\Tasks;

class Lat
{
	public function long()
	{
		$res = \Model_Rescue::find()
				->where('lat', "")
				->get();

		foreach ($res as $r) {
			$address = urlencode($r->address. ", ". $r->city->name);

			//$url = "http://maps.googleapis.com/maps/api/geocode/json?address=". $address ."&sensor=false";
			$url = "http://maps.google.com/maps/api/geocode/json?address=<?php echo $address;?>&sensor=true&region=philippines";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);

			if (isset($response_a->results[0]->geometry->location->lat)) {
				$lat = $response_a->results[0]->geometry->location->lat;
				$lng = $response_a->results[0]->geometry->location->lng;

				$newlat = \Model_Rescue::find($r->id);
				$newlat->lat = $lat;
				$newlat->lng = $lng;
				$newlat->save();
			}
		}
	}
}
