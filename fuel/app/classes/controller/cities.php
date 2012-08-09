<?php
class Controller_Cities extends Controller_Template 
{

	public function action_index()
	{
		$data['cities'] = Model_City::find('all');
		$this->template->title = "Cities";
		$this->template->content = View::forge('cities/index', $data);

	}

	public function action_view($id = null)
	{
		$data['city'] = Model_City::find($id);

		is_null($id) and Response::redirect('Cities');

		$this->template->title = "City";
		$this->template->content = View::forge('cities/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_City::validate('create');
			
			if ($val->run())
			{
				$city = Model_City::forge(array(
					'name' => Input::post('name'),
				));

				if ($city and $city->save())
				{
					Session::set_flash('success', 'Added city #'.$city->id.'.');

					Response::redirect('cities');
				}

				else
				{
					Session::set_flash('error', 'Could not save city.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Cities";
		$this->template->content = View::forge('cities/create');

	}

	public function action_edit($id = null)
	{
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}

		is_null($id) and Response::redirect('Cities');

		$city = Model_City::find($id);

		$val = Model_City::validate('edit');

		if ($val->run())
		{
			$city->name = Input::post('name');

			if ($city->save())
			{
				Session::set_flash('success', 'Updated city #' . $id);

				Response::redirect('cities');
			}

			else
			{
				Session::set_flash('error', 'Could not update city #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$city->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('city', $city, false);
		}

		$this->template->title = "Cities";
		$this->template->content = View::forge('cities/edit');

	}

	public function action_delete($id = null)
	{
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}
		
		if ($city = Model_City::find($id))
		{
			$city->delete();

			Session::set_flash('success', 'Deleted city #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete city #'.$id);
		}

		Response::redirect('cities');

	}


}