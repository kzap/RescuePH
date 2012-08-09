<?php
class Controller_Rescue extends Controller_Template 
{

	public function action_index()
	{
		$rescue = Model_Rescue::find();


		if (Input::post('city_id')) {
			$rescue->where('city_id', Input::post('city_id'));
			$city = Model_City::find(Input::post('city_id'));
			$this->template->set_global('city', $city, false);

			$pointer = $rescue->get();
			$this->template->set_global('pointer', $pointer, false);

			$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->where("city_id", Input::post('city_id'))
						->order_by("id", "DESC")
						->limit(100)
						->get();

		}
		else
		{
			$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->order_by("id", "DESC")
						->limit(5)
						->get();
		}

		$this->template->set_global('lat', $lat, false);


		$pointer = $rescue->get();
		$this->template->set_global('pointer', $pointer, false);

		$rescue->order_by('id','desc')->limit(30);
		$r = $rescue->get();
		$data['rescues'] = $r;
		$this->template->title = "#RescuePH";
		$this->template->content = View::forge('rescue/index', $data);

		//cities


		$categories = Model_city::find()
					->order_by('name')
					->get();
		$c = array(""=>" by city ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('cities', $c, false);

	}
	public function action_test()
	{
		$rescue = Model_Rescue::find();


		if (Input::post('city_id')) {
			$rescue->where('city_id', Input::post('city_id'));
			$city = Model_City::find(Input::post('city_id'));
			$this->template->set_global('city', $city, false);

			$pointer = $rescue->get();
			$this->template->set_global('pointer', $pointer, false);

			$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->where("city_id", Input::post('city_id'))
						->order_by("id", "DESC")
						->limit(100)
						->get();

		}
		else
		{
			$lat = Model_Rescue::find()
						->where("lat", "!=", "")
						->order_by("id", "DESC")
						->limit(100)
						->get();
		}

		$this->template->set_global('lat', $lat, false);


		$pointer = $rescue->get();
		$this->template->set_global('pointer', $pointer, false);

		$rescue->order_by('id','desc')->limit(30);
		$r = $rescue->get();
		$data['rescues'] = $r;
		$this->template->title = "#RescuePH";
		$this->template->content = View::forge('rescue/test', $data);

		//cities


		$categories = Model_city::find()
					->order_by('name')
					->get();
		$c = array(""=>" by city ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('cities', $c, false);

	}
	public function action_view($id = null)
	{
		$data['rescue'] = Model_Rescue::find($id);

		is_null($id) and Response::redirect('Rescue');

		$this->template->title = "Rescue";
		$this->template->content = View::forge('rescue/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Rescue::validate('create');
			
			if ($val->run())
			{
				if (Cookie::get('theuser_id'))
				{
					$theuser_id = Cookie::get('theuser_id');
				}
				else
				{
					$theuser_id = '1';
				}

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


				$rescue = Model_Rescue::forge(array(
					'name' => Input::post('name'),
					'address' => Input::post('address'),
					'city_id' => Input::post('city_id'),
					'specifics' => Input::post('specifics'),
					'reporter' => Input::post('reporter'),
					'source' => Input::post('source'),
					'status_id' => Input::post('status_id'),
					'theuser_id' => $theuser_id,
					'lat' => $lat,
					'lng' => $lng,
				));




				if ($rescue and $rescue->save())
				{
					Session::set_flash('success', 'Added rescue #'.$rescue->id.'.');

					Response::redirect('rescue');
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
		$this->template->content = View::forge('rescue/create');

		//cities


		$categories = Model_city::find()
					->order_by('name')
					->get();
		$c = array(""=>" -- ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('cities', $c, false);

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
		is_null($id) and Response::redirect('Rescue');

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

			if ($rescue->save())
			{
				Session::set_flash('success', 'Updated rescue #' . $id);

				Response::redirect('rescue');
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
		$this->template->content = View::forge('rescue/edit');

			//cities


		$categories = Model_city::find()
					->order_by('name')
					->get();
		$c = array(""=>" -- ");
		foreach ($categories as $cat) {
			$c[$cat->id] = $cat->name;
		}
		$this->template->set_global('cities', $c, false);

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

		Response::redirect('rescue');

	}

	public function action_lat()
	{
		$this->auto_render  = FALSE;;
		$address = urlencode("Mandaluyong City, Philippines");
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
echo $lat = $response_a->results[0]->geometry->location->lat;
		
	}


}