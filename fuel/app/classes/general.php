<?php 
	Class General
	{
		static function latlong($address)
		{
			$address = urlencode($address);

			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=". $address ."&sensor=false";

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

				return $lat.",".$lng;
			}else
			{
				return false;
			}
		}
	}

 