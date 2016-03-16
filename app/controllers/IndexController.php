<?php

namespace UserApp\Controllers;
use UserApp\Services\ViewMaker;
use UserApp\Models\Crud;

class IndexController
{
	
	public function index()
	{
	
		/*
		$crud = new Crud;	
		var_dump($crud->create('users', ['email' => 'storm@err0r.dk', 'password' => 'j26211', 'created_at' => now()]));
		*/
	
		$view = new ViewMaker();
		$view->render('login');
	}

	public function loggedin()
	{
		if(!isset($_SESSION['user_id']))
		{
			$_SESSION['message'] = ['type' => 'warning', 'content' => 'Du skal være logget ind for at se denne side'];
			redirect('/login');
		}

		$crud = new Crud;
		$user = $crud->read('users', 'id=:user_id', [':user_id' => $_SESSION['user_id']]);
		if(empty($user))
		{
			$_SESSION['message'] = ['type' => 'warning', 'content' => 'Det lader ikke til du længere er medlem på sitet'];
			unset($_SESSION['user_id']);
			redirect('/login');			
		}

		$groups = $crud->read('group_user, groups', 'group_user.user_id=:user_id AND group_user.group_id=groups.id', [':user_id' => $user[0]['id']]);

		$view = new ViewMaker('adminlayout');
		$view->render('loggedin', ['user' => $user[0], 'groups' => $groups]);
	}


}