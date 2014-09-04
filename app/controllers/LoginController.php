<?php

namespace Zitcom\Controllers;
use Zitcom\Services\ViewMaker;
use Zitcom\Models\Crud;


class LoginController
{
	
	public function login()
	{
		$crud = new Crud;

		try
		{
			$user = $crud->read('users', 'email=:email', [':email' => $_POST['email']]);
			if(!empty($user))
			{
				if(password_verify($_POST['password'], $user[0]['password']))
				{
					$_SESSION['user_id'] = $user[0]['id'];
					redirect('/loggedin');
				}
				else
				{
					$_SESSION['message'] = ['type' => 'danger', 'content' => 'Forkert email eller kodeord'];
					redirect('/');
				}
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}
		
	}


}