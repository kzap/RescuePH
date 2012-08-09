<?php
class Controller_Statuses extends Controller_Template 
{

	public function action_index()
	{
		$data['statuses'] = Model_Status::find('all');
		$this->template->title = "Statuses";
		$this->template->content = View::forge('statuses/index', $data);

	}

	public function action_view($id = null)
	{
		$data['status'] = Model_Status::find($id);

		is_null($id) and Response::redirect('Statuses');

		$this->template->title = "Status";
		$this->template->content = View::forge('statuses/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Status::validate('create');
			
			if ($val->run())
			{
				$status = Model_Status::forge(array(
					'name' => Input::post('name'),
				));

				if ($status and $status->save())
				{
					Session::set_flash('success', 'Added status #'.$status->id.'.');

					Response::redirect('statuses');
				}

				else
				{
					Session::set_flash('error', 'Could not save status.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Statuses";
		$this->template->content = View::forge('statuses/create');

	}

	public function action_edit($id = null)
	{
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}
		
		is_null($id) and Response::redirect('Statuses');

		$status = Model_Status::find($id);

		$val = Model_Status::validate('edit');

		if ($val->run())
		{
			$status->name = Input::post('name');

			if ($status->save())
			{
				Session::set_flash('success', 'Updated status #' . $id);

				Response::redirect('statuses');
			}

			else
			{
				Session::set_flash('error', 'Could not update status #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$status->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('status', $status, false);
		}

		$this->template->title = "Statuses";
		$this->template->content = View::forge('statuses/edit');

	}

	public function action_delete($id = null)
	{
		if (!Cookie::get('theuser_id'))
		{
			Response::redirect('login');
		}

		if ($status = Model_Status::find($id))
		{
			$status->delete();

			Session::set_flash('success', 'Deleted status #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete status #'.$id);
		}

		Response::redirect('statuses');

	}


}