<?php

namespace Zitcom\Controllers;
use Zitcom\Services\ViewMaker;
use Zitcom\Models\Crud;

class AdminController
{

	private $crud;

	public function __construct()
	{
		$this->crud = new Crud;
	}
	
	public function index()
	{		

		$users = $this->crud->read('users');
		$groups = $this->crud->read('groups');

		$view = new ViewMaker('adminlayout');
		$view->render('dashboard', ['users' => $users, 'groups' => $groups]);
	}

	public function createuser()
	{

		$groups = $this->crud->read('groups');

		$view = new ViewMaker('adminlayout');
		$view->render('createuser', ['groups' => $groups]);
	}

	public function creategroup()
	{
		$view = new ViewMaker('adminlayout');
		$view->render('creategroup');
	}

	public function editgroup($params)
	{
		$id = $params['id'];
		$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);

		$view = new ViewMaker('adminlayout');
		$view->render('editgroup', ['group' => $group[0]]);
	}


	public function posteditgroup($params)
	{
		$id = $params['id'];
		$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);

		if(!empty($_POST['name']))
		{
			$this->crud->update('groups', ['name' => $_POST['name']], 'id=:group_id', [':group_id' => $id]);
			redirect('/dashboard');
		}
		else
		{
			$_SESSION['message'] = ['type' => 'danger', 'content' => 'Du skal angive et navn'];
		}

		$view = new ViewMaker('adminlayout');
		$view->render('editgroup', ['group' => $group[0]]);
	}


	public function edituser($params)
	{
		$id = $params['id'];
		$user = $this->crud->read('users', 'id=:id', [':id' => $id]);
		$groups = $this->crud->read('groups');
		$usergroups = $this->crud->read('group_user', 'user_id=:user_id', [':user_id' => $id]);


		$hasgroups = array();
		foreach($usergroups as $usergroup)
			$hasgroups[] = $usergroup['group_id'];



		$view = new ViewMaker('adminlayout');
		$view->render('edituser', ['groups' => $groups, 'user' => $user[0], 'has_groups' => $hasgroups] );
	}

	public function postedituser($params)
	{
		$id = $params['id'];
		$user = $this->crud->read('users', 'id=:id', [':id' => $id]);
		$error = false;

		$mail = $this->crud->read('users', 'email=:email', [':email' => $_POST['email']]);

		if($_POST['password'] != $_POST['password_confirm'])
		{
			$_SESSION['message'] = ['type' => 'danger', 'content' => 'Kodeord matcher ikke overens'];
			$error = true;
		}
		elseif(!empty($mail))
		{
			if($mail[0]['id'] != $user[0]['id'])
			{
				$_SESSION['message'] = ['type' => 'danger', 'content' => 'E-mail adressen er allerede i brug'];
				$error = true;				
			}

		}

		if(!$error)
		{

			$data = ['email' => $_POST['email'], 'updated_at' => now()];
			if(!empty($_POST['password']))
				 $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$user_id = $this->crud->update('users', $data, 'id=:user_id', [':user_id' => $id]);
			$this->crud->delete('group_user', 'user_id=:user_id', [':user_id' => $id]);
			
			if(isset($_POST['groups']))
			{
				foreach ($_POST['groups'] as $key => $value) 
				{
					$this->crud->create('group_user', ['user_id' => $id, 'group_id' => $value]);
				}
			}

			redirect('/dashboard');
		}

		$groups = $this->crud->read('groups');
		$usergroups = $this->crud->read('group_user', 'user_id=:user_id', [':user_id' => $id]);


		$hasgroups = array();
		foreach($usergroups as $usergroup)
			$hasgroups[] = $usergroup['group_id'];



		$view = new ViewMaker('adminlayout');
		$view->render('edituser', ['groups' => $groups, 'user' => $user[0], 'has_groups' => $hasgroups] );
	}


	public function postcreateuser()
	{

		$error = false;
		$user = $this->crud->read('users', 'email=:email', [':email' => $_POST['email']]);

		if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'])
		{
			$_SESSION['message'] = ['type' => 'danger', 'content' => 'Kodeord matcher ikke overens'];
			$error = true;
		}
		elseif(!empty($user))
		{
			$_SESSION['message'] = ['type' => 'danger', 'content' => 'Mail-adressen er allerede i brug'];	
			$error = true;
		}

		if(!$error)
		{
			$user_id = $this->crud->create('users', ['email' => $_POST['email'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'created_at' => now()]);
			if(isset($_POST['groups']))
			{
				foreach ($_POST['groups'] as $key => $value) 
				{
					$this->crud->create('group_user', ['user_id' => $user_id, 'group_id' => $value]);
				}
			}

			redirect('/dashboard');
		}


		$groups = $this->crud->read('groups');

		$view = new ViewMaker('adminlayout');
		$view->render('createuser', ['groups' => $groups]);
	}

	public function postcreategroup()
	{
		
		$this->crud->create('groups', ['name' => $_POST['name']]);
		redirect('/dashboard');
	}

	public function deleteuser($params)
	{
		$id = $params['id'];
		$this->crud->delete('users', 'id=:id', [':id' => $id]);
		$this->crud->delete('group_user', 'user_id=:id', [':id' => $id]);
		redirect('/dashboard');
	}

	public function deletegroup($params)
	{
		$id = $params['id'];
		$this->crud->delete('groups', 'id=:id', [':id' => $id]);
		$this->crud->delete('group_user', 'group_id=:id', [':id' => $id]);
		redirect('/dashboard');
	}

	public function groupmembers($params)
	{
		$id = $params['id'];
		$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);
		$tmp_users = $this->crud->read('group_user, users', 'group_user.group_id=:group_id AND group_user.user_id=users.id', [':group_id' => $id]);

		$real_users = [];
		foreach($tmp_users as $tmp_user)
		{
			if(!isset($real_users[$tmp_user['id']]))
			{
				$real_users[$tmp_user['id']] = $tmp_user;
			}
		}

		$view = new ViewMaker('adminlayout');
		$view->render('groupmembers', ['users' => $real_users, 'group' => $group[0]]);

	}


}