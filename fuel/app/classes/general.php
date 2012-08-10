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
		
		static function getAreaSelectOptions($type = null) {
		
			switch ($type) {
				case 3:
					$regionsJsonData = array();
					$regions = Model_GeoRegionName::find()->get();
					foreach ($regions as $region) {
						$regionsJsonData[$region->country_code . '|' . $region->region_id] = array(
							'region_name' => $region->region_name,
							'cities' => array(),
						);
						$cities = $region->GeoCityNames;
						foreach ($cities as $city) {
							$regionsJsonData[$region->country_code . '|' . $region->region_id]['cities'][] = array(
								'city_id' => $city->city_id,
								'city_name' => $city->city_name,
							);
						}
					}
					
					return json_encode($regionsJsonData);
				break;
					
				case 2:
					$areaSelectOptions = array();
					$prependOptions = array(
						array(
							'label' => 'Select a City / Municipality',
							'value' => '',
						),
					);
					
					$regions = Model_GeoRegionName::find()->get();
					foreach ($regions as $region) {
						$cities = $region->GeoCityNames;
						
						if ($region->region_name == 'Metro Manila') {
							
							$cityOptions = array();
							foreach ($cities as $city) {
								$cityOptions[] = array(
									'label' => $city->city_region_name,
									'value' => $city->city_id,
								);
							}
							$prependOptions[] = array(
								'label' => $region->region_name,
								'options' => $cityOptions,
							);
							
						} else {
							
							$cityOptions = array();
							foreach ($cities as $city) {
								$cityOptions[] = array(
									'label' => $city->city_region_name,
									'value' => $city->city_id,
								);
							}
							$areaSelectOptions[] = array(
								'label' => $region->region_name,
								'options' => $cityOptions,
							);
							
						}
					}
					
					// prepend $prependOptions
					foreach (array_reverse($prependOptions) as $prependOption) {
						array_unshift($areaSelectOptions, $prependOption);			
					}
					
					return $areaSelectOptions;
				break;
					
				case 1:
				default:
					$areaSelectOptions = array();
					$prependOptions = array(
						array(
							'label' => 'Select a City / Region',
							'value' => '',
						),
					);
					
					$regions = Model_GeoRegionName::find()->get();
					foreach ($regions as $region) {
						$cities = $region->GeoCityNames;
						
						if ($region->region_name == 'Metro Manila') {
							$prependOptions[] = array(
								'label' => $region->region_name,
								'value' => 'REGION|' . $region->country_code . '|' . $region->region_id,
							);
							$metroManilaCityOptions = array();
							foreach ($cities as $city) {
								$metroManilaCityOptions[] = array(
									'label' => $city->city_name,
									'value' => 'CITY|' . $city->city_id,
								);
							}
							$prependOptions[] = array(
								'label' => str_repeat('-', strlen($region->region_name)),
								'options' => $metroManilaCityOptions,
							);
						} else {
						
							$areaSelectOptions[] = array(
								'label' => $region->region_name,
								'value' => 'REGION|' . $region->country_code . '|' . $region->region_id,
							);
						}
					}
					
					// prepend $prependOptions
					foreach (array_reverse($prependOptions) as $prependOption) {
						array_unshift($areaSelectOptions, $prependOption);			
					}
					
					return $areaSelectOptions;
				break;
			}
		}
	
		static function getAreaCitySelectOptions($cities = array()) {
			
			$areaCitySelectOptions = array();
			$prependOptions = array(
				array(
					'label' => 'Select a City / Municipality',
					'value' => '',
				),
			);
			
			foreach ($cities as $city) {
				$areaCitySelectOptions[] = array(
					'label' => $city->city_name,
					'value' => $city->city_id,
				);
			}
			
			// prepend $prependOptions
			foreach (array_reverse($prependOptions) as $prependOption) {
				array_unshift($areaCitySelectOptions, $prependOption);			
			}
			
			return $areaCitySelectOptions;
		}
	}

 