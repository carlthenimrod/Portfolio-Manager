<?php

class Users_Controller extends Base_Controller
{
	public function action_login()
	{
		return View::make('portfolios.login');
	}

	public function action_logout()
	{
		Auth::logout();

		return Redirect::to('portfolios/login');
	}

	public function action_session()
	{
		$input = Input::all();

		$credentials = array(

			'username' => $input['email'],
			'password' => $input['password']
		);

		if(Auth::attempt($credentials)){

			return Redirect::to('portfolios/');
		}
		else{

			Session::flash('failed', 'Login failed! Username/Password incorrect.');

			return Redirect::to('portfolios/login');
		}
	}
}

?>