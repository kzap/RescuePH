<?php 

Class Controller_Map extends Controller
{
	public function action_lat($city_id = NULL)
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		if (strpos($city_id, 'REGION|') !== FALSE) {
			// its a region
			$regionId = explode('|', str_replace('REGION|', '', $city_id));
			$region = Model_GeoRegionName::find($regionId);
			$cities = $region->GeoCityNames;
			
		} elseif (strpos($city_id, 'CITY|') !== FALSE || (int) $city_id) {
			// its a city
			$cityId = (int) str_replace('CITY|', '', $city_id);
			$city = Model_GeoCityName::find($cityId);
		}
		
		$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->order_by("id", "DESC")
						->limit(100);
						
		if (isset($cityId) && $cityId) {
			
			$lat->where('city_id', (int) $cityId);
			
		} elseif (isset($regionId) && !empty($cities)) {
			
			$cityIds = array();
			foreach ($cities as $city) { $cityIds[] = $city->city_id; }
			if (!empty($cityIds)) {
				$lat->where('city_id', 'in', (array) $cityIds);
			}
				
		}
						
		$l = $lat->get();

		$map = View::forge('map/lat');
		$map->lat = $l;
		return $map;
	}
}