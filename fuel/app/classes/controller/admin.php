<?php
class Controller_Admin extends Controller_Template 
{

	public function action_index()
	{
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}
		
		$rescue = Model_Rescue::find();
		
		if (Input::post('areaSelect', false)) {
			$areaSelect = Input::post('areaSelect');
			if (strpos($areaSelect, 'REGION|') !== FALSE) {
				// its a region
				$regionId = explode('|', str_replace('REGION|', '', $areaSelect));
				$region = Model_GeoRegionName::find($regionId);
				$this->template->set_global('regionInfo', $region, false);
				
				$cities = $region->GeoCityNames;
				
				if ($region->region_name != 'Metro Manila') {
					$areaCitySelectOptions = General::getAreaCitySelectOptions($cities);
					$this->template->set_global('areaCitySelectOptions', $areaCitySelectOptions, false);
				}
				
			} elseif (strpos($areaSelect, 'CITY|') !== FALSE) {
				// its a city
				$cityId = (int) str_replace('CITY|', '', $areaSelect);
				$city = Model_GeoCityName::find($cityId);
				$this->template->set_global('cityInfo', $city, false);
			}
		}
		
		if (Input::post('areaCitySelect', false)) {
			$cityId = (int) Input::post('areaCitySelect');
			$city = Model_GeoCityName::find($cityId);
			$this->template->set_global('cityInfo', $city, false);
		}
		
		if (isset($cityId) && $cityId) {
			
			$rescue->where('city_id', (int) $cityId);
			
		} elseif (isset($regionId) && !empty($cities)) {
			
			$cityIds = array();
			foreach ($cities as $city) { $cityIds[] = $city->city_id; }
			if (!empty($cityIds)) {
				$rescue->where('city_id', 'in', (array) $cityIds);
			}
				
		}

		if (Input::post('status_id', false)) {
			$rescue->where('status_id', Input::post('status_id'));

			$status = Model_Status::find(Input::post('status_id'));
			$this->template->set_global('status', $status, false);
		}
		
		$data['rescues'] = $rescue->get();
		$this->template->title = "#RescuePH";
		$this->template->content = View::forge('admin/index', $data);

		//areaSelectOptions
		$areaSelectOptions = General::getAreaSelectOptions();
		$this->template->set_global('areaSelectOptions', $areaSelectOptions, false);

		//status
		$statuses = Model_Status::find()
					->get();
		$c = array(
			array(
				'label' => ' -- ',
				'value' => '',
			),
		);
		foreach ($statuses as $status) {
			$c[] = array(
				'label' => $status->name,
				'value' => $status->id,
			);
		}
		$this->template->set_global('statuses', $c, false);

	}



	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Rescue::validate('create');
			
			if ($val->run())
			{
				$rescue = Model_Rescue::forge(array(
					'name' => Input::post('name'),
					'address' => Input::post('address'),
					'city_id' => Input::post('city_id'),
					'specifics' => Input::post('specifics'),
					'reporter' => Input::post('reporter'),
					'source' => Input::post('source'),
					'status_id' => Input::post('status_id'),
				));

				if ($rescue and $rescue->save())
				{
					Session::set_flash('success', 'Added rescue #'.$rescue->id.'.');

					Response::redirect('admin');
				}

				else
				{
					Session::set_flash('error', 'Could not save rescue.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Rescues";
		$this->template->content = View::forge('admin/create');

		//citySelectOptions
		$citySelectOptions = General::getAreaSelectOptions(2);
		$this->template->set_global('citySelectOptions', $citySelectOptions, false);
		
		//status
		$categories = Model_Status::find()
					->get();
		$c = array(""=>" -- ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('statuses', $c, false);


	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('admin');

		$rescue = Model_Rescue::find($id);

		$val = Model_Rescue::validate('edit');

		if ($val->run())
		{
			$rescue->name = Input::post('name');
			$rescue->address = Input::post('address');
			$rescue->city_id = Input::post('city_id');
			$rescue->specifics = Input::post('specifics');
			$rescue->reporter = Input::post('reporter');
			$rescue->source = Input::post('source');
			$rescue->status_id = Input::post('status_id');

			if (Cookie::get('theuser_id'))
				{
					$theuser_id = Cookie::get('theuser_id');
				}
				else
				{
					$theuser_id = '1';
				}
			$rescue->theuser_id = $theuser_id;	

			$city = Model_City::find(Input::post('city_id'));

			$lat = Input::post('address'). " ". $city->name. ", Philippines";

				//echo $lat;
				//exit;

				$long = General::latlong($lat);

				if ($long)
				{
					$latlong = explode(",", $long);
					$lat = $latlong[0];
					$lng = $latlong[1];
				}else
				{
					$lat = "";
					$lng = "";
				}

			$rescue->lat = $lat;
			$rescue->lng = $lng;

			if ($rescue->save())
			{
				Session::set_flash('success', 'Updated rescue #' . $id);

				Response::redirect('admin');
			}

			else
			{
				Session::set_flash('error', 'Could not update rescue #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$rescue->name = $val->validated('name');
				$rescue->address = $val->validated('address');
				$rescue->city_id = $val->validated('city_id');
				$rescue->specifics = $val->validated('specifics');
				$rescue->reporter = $val->validated('reporter');
				$rescue->source = $val->validated('source');
				$rescue->status_id = $val->validated('status_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('rescue', $rescue, false);
		}

		$this->template->title = "Rescues";
		$this->template->content = View::forge('admin/edit');

		//citySelectOptions
		$citySelectOptions = General::getAreaSelectOptions(2);
		$this->template->set_global('citySelectOptions', $citySelectOptions, false);

		//status
		$categories = Model_Status::find()
					->get();
		$c = array(""=>" -- ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('statuses', $c, false);

	}

	public function action_delete($id = null)
	{
		if ($rescue = Model_Rescue::find($id))
		{
			$rescue->delete();

			Session::set_flash('success', 'Deleted rescue #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete rescue #'.$id);
		}

		Response::redirect('admin');

	}
	
	public function action_updatecities($safety_off = NULL)
	{
		exit; // already ran, no longer needed
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}
		
		$oldToNewCityIds = array(
			1 => 972, //'name'=>'Mandaluyong','city_id'=>972,'country_code'=>'PH','region_id'=>48,'city_name'=>'Mandaluyong','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Mandaluyong, Metro Manila'),
  			2 => 979, //'name'=>'Pasig','city_id'=>979,'country_code'=>'PH','region_id'=>48,'city_name'=>'Pasig','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Pasig, Metro Manila'),
  			3 => 971, //'name'=>'Malabon','city_id'=>971,'country_code'=>'PH','region_id'=>48,'city_name'=>'Malabon','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Malabon, Metro Manila'),
			4 => 981, //'name'=>'San Juan','city_id'=>981,'country_code'=>'PH','region_id'=>48,'city_name'=>'San Juan','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'San Juan, Metro Manila'),
			5 => 975, //'name'=>'Muntinlupa','city_id'=>975,'country_code'=>'PH','region_id'=>48,'city_name'=>'Muntinlupa','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Muntinlupa, Metro Manila'),
  			6 => 980, //'name'=>'Quezon City','city_id'=>980,'country_code'=>'PH','region_id'=>48,'city_name'=>'Quezon City','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Quezon City, Metro Manila'),
  			7 => 974, //'name'=>'Marikina City','city_id'=>null,'country_code'=>null,'region_id'=>null,'city_name'=>null,'postal_code'=>null,'latitude'=>null,'longitude'=>null,'metro_code'=>null,'area_code'=>null,'city_region_name'=>null),
  			8 => 968, //'name'=>'Caloocan City','city_id'=>null,'country_code'=>null,'region_id'=>null,'city_name'=>null,'postal_code'=>null,'latitude'=>null,'longitude'=>null,'metro_code'=>null,'area_code'=>null,'city_region_name'=>null),
  			9 => 969, //'name'=>'Las Pinas','city_id'=>969,'country_code'=>'PH','region_id'=>48,'city_name'=>'Las Piñas','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Las Piñas, Metro Manila'),
  			10 => 970, //'name'=>'Makati','city_id'=>970,'country_code'=>'PH','region_id'=>48,'city_name'=>'Makati','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Makati, Metro Manila'),
  			11 => 973, //'name'=>'Manila','city_id'=>973,'country_code'=>'PH','region_id'=>48,'city_name'=>'Manila','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Manila, Metro Manila'),
  			13 => 976, //'name'=>'Navotas','city_id'=>976,'country_code'=>'PH','region_id'=>48,'city_name'=>'Navotas','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Navotas, Metro Manila'),
  			14 => 977, //'name'=>'Paranaque','city_id'=>977,'country_code'=>'PH','region_id'=>48,'city_name'=>'Parañaque','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Parañaque, Metro Manila'),
  			15 => 978, //'name'=>'Pasay','city_id'=>978,'country_code'=>'PH','region_id'=>48,'city_name'=>'Pasay','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Pasay, Metro Manila'),
  			16 => 984, //'name'=>'Pateros','city_id'=>984,'country_code'=>'PH','region_id'=>48,'city_name'=>'Pateros','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Pateros, Metro Manila'),
  			17 => 982, //'name'=>'Taguig','city_id'=>982,'country_code'=>'PH','region_id'=>48,'city_name'=>'Taguig','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Taguig, Metro Manila'),
  			18 => 983, //'name'=>'Valenzuela','city_id'=>983,'country_code'=>'PH','region_id'=>48,'city_name'=>'Valenzuela','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Valenzuela, Metro Manila'),
  			19 => 286, //'name'=>'Bulacan','city_id'=>286,'country_code'=>'PH','region_id'=>17,'city_name'=>'Bulacan','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>44,'city_region_name'=>'Bulacan, Bulacan'),
  			20 => 1337, //'name'=>'Cainta','city_id'=>1337,'country_code'=>'PH','region_id'=>64,'city_name'=>'Cainta','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>2,'city_region_name'=>'Cainta, Rizal'),
  			21 => 792, //'name'=>'Rizal','city_id'=>792,'country_code'=>'PH','region_id'=>41,'city_name'=>'Rizal','postal_code'=>'','latitude'=>0,'longitude'=>0,'metro_code'=>'','area_code'=>49,'city_region_name'=>'Rizal, Laguna'),
	  		22 => 1216, //'name'=>'Pampanga','city_id'=>null,'country_code'=>null,'region_id'=>null,'city_name'=>null,'postal_code'=>null,'latitude'=>null,'longitude'=>null,'metro_code'=>null,'area_code'=>null,'city_region_name'=>null),
  			23 => 768, //'name'=>'Laguna','city_id'=>null,'country_code'=>null,'region_id'=>null,'city_name'=>null,'postal_code'=>null,'latitude'=>null,'longitude'=>null,'metro_code'=>null,'area_code'=>null,'city_region_name'=>null),
  			24 => 1333, //'name'=>'Antipolo','city_id'=>null,'country_code'=>null,'region_id'=>null,'city_name'=>null,'postal_code'=>null,'latitude'=>null,'longitude'=>null,'metro_code'=>null,'area_code'=>null,'city_region_name'=>null)
  			25 => 1549, //Zambales
  			26 => 414, // Cavite
  			27 => 768, // Laguna
		);
		
		foreach ($oldToNewCityIds as $oldCityId => $newCityId) {
			if ($safety_off == 12345) {
				$query = DB::update('rescues')
    						->value('city_id', $newCityId)
    						->where('city_id', '=', $oldCityId);
				$rows = $query->execute();
				if ($rows) {
					echo $rows . ' Rescues Old City ID #' . $oldCityId . ' updated to New City ID #' . $newCityId . '<br />';
				}  
			} else {
				$count = DB::select('id')
							->from('rescues')
    						->where('city_id', '=', $oldCityId)
							->execute();
				echo count($count) . ' Rescues to Update for Old City ID #' . $oldCityId . ' to New City ID #' . $newCityId . '<br />';
			}
		}
	}

}
