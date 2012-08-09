<?php
class Controller_Login extends Controller_Template 
{

	public function action_index()
	{
		Response::redirect('login/edit');

	}

	

	public function action_edit()
	{
		// is_null($id) and Response::redirect('Login');

		 // $login = Model_Login::find($id);

		// $val = Model_Login::validate('edit');

		
			if (Input::method() == 'POST')
			{
				$username = Input::post('username');
				$password = Input::post('password');

				$log = Model_Login::find()
							->where('username', $username)
							->where('password', $password)
							->get_one();
				if (!$log)
				{
					Session::set_flash('error', "Error login");
				}else
				{
					Cookie::set('theuser_id', $log->id);
					Response::redirect('admin');
				}
				
			}

		

		$this->template->title = "Logins";
		$this->template->content = View::forge('login/edit');

	}



}