<?php
class Controller_Theusers extends Controller_Template 
{

	public function action_index()
	{
		$data['theusers'] = Model_Theuser::find('all');
		$this->template->title = "Theusers";
		$this->template->content = View::forge('theusers/index', $data);

	}

	public function action_view($id = null)
	{
		$data['theuser'] = Model_Theuser::find($id);

		is_null($id) and Response::redirect('Theusers');

		$this->template->title = "Theuser";
		$this->template->content = View::forge('theusers/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Theuser::validate('create');
			
			if ($val->run())
			{
				$theuser = Model_Theuser::forge(array(
					'username' => Input::post('username'),
					'password' => Input::post('password'),
					'name' => Input::post('name'),
				));

				if ($theuser and $theuser->save())
				{
					Session::set_flash('success', 'Added theuser #'.$theuser->id.'.');

					Response::redirect('theusers');
				}

				else
				{
					Session::set_flash('error', 'Could not save theuser.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Theusers";
		$this->template->content = View::forge('theusers/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Theusers');

		$theuser = Model_Theuser::find($id);

		$val = Model_Theuser::validate('edit');

		if ($val->run())
		{
			$theuser->username = Input::post('username');
			$theuser->password = Input::post('password');
			$theuser->name = Input::post('name');

			if ($theuser->save())
			{
				Session::set_flash('success', 'Updated theuser #' . $id);

				Response::redirect('theusers');
			}

			else
			{
				Session::set_flash('error', 'Could not update theuser #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$theuser->username = $val->validated('username');
				$theuser->password = $val->validated('password');
				$theuser->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('theuser', $theuser, false);
		}

		$this->template->title = "Theusers";
		$this->template->content = View::forge('theusers/edit');

	}

	public function action_delete($id = null)
	{
		if ($theuser = Model_Theuser::find($id))
		{
			$theuser->delete();

			Session::set_flash('success', 'Deleted theuser #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete theuser #'.$id);
		}

		Response::redirect('theusers');

	}


}