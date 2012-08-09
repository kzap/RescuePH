<?php 

Class Controller_Map extends Controller
{
	public function action_lat($city_id = NULL)

	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->order_by("id", "DESC")
						->limit(100);
		if ($city_id)
		{
			$l = $lat->where('city_id', $city_id);
		}				
		$l = $lat->get();

		$map = View::forge('map/lat');
		$map->lat = $l;
		return $map;
	}
}