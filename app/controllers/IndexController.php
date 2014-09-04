<?php

namespace Zitcom\Controllers;
use Zitcom\Services\ViewMaker;
use Zitcom\Models\User;

class IndexController
{
	
	public function index()
	{

		var_dump(User::find(1));
		$user = new User();	
		var_dump($user);
	
		$view = new ViewMaker();
		$view->render('login');
	}


	public function create_user()
	{
		$view = new ViewMaker();
		$view->render('login');
	}	
}