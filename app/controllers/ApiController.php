<?php

namespace UserApp\Controllers;
use UserApp\Models\Crud;

class ApiController
{

	private $crud;

	public function __construct()
	{
		$this->crud = new Crud;
	}
	
	private function _groups()
	{
		$tmp_groups = [];
		$groups = $this->crud->read('groups');

		foreach ($groups as $group) 
		{
			$tmp_groups[$group['id']] = $group['name'];
		}

		return $tmp_groups;
	}

	public function createuser()
	{

		if($user = json_decode(file_get_contents('php://input')))
		{
			if(!isset($user->email) || !isset($user->password))
				exit(json_encode(['error' => 'Missing field email or password']));

			$tmp_user = $this->crud->read('users', 'email=:email', [':email' => $user->email]);
			if(!empty($tmp_user))
				exit(json_encode(['error' => 'E-mail is already in use']));


			$groups = $this->_groups();
			$user_id = $this->crud->create('users', ['email' => $user->email, 'password' => password_hash($user->password, PASSWORD_DEFAULT), 'created_at' => now()]);
			if(isset($user->groups))
			{
				foreach ($user->groups as $key => $value) 
				{
					if(isset($groups[$value]))
						$this->crud->create('group_user', ['user_id' => $user_id, 'group_id' => $value]);
				}
			}


			return $this->singleuser(['id' => $user_id]);


		}
		else
		{
			exit(json_encode(['error' => 'Invalid JSON']));
		}

	}

	public function singleuser($params)
	{
		$id = $params['id'];
		$user = $this->crud->read('users', 'id=:id', [':id' => $id]);
		$user[0]['groups'] = [];		
		foreach($this->crud->read('group_user', 'user_id=:user_id', [':user_id' => $id]) as $user_group)
		{

			$user[0]['groups'][] = $user_group['group_id'];
		}



		exit(json_encode($user[0]));
	}

	public function updateuser($params)
	{

		if($input = json_decode(file_get_contents('php://input')))
		{
			if(!isset($input->email) || !isset($input->password))
				exit(json_encode(['error' => 'Missing field email or password']));

			$id = $params['id'];		
			$user = $this->crud->read('users', 'id=:id', [':id' => $id]);

			if(empty($user))
				exit(json_encode(['error' => 'Resource cannot be found']));

			$mail = $this->crud->read('users', 'email=:email', [':email' => $input->email]);


			if(!empty($mail))
			{
				if($mail[0]['id'] != $user[0]['id'])
				{
					exit(json_encode(['error' => 'E-mail is already in use']));
				}

			}

			$data['email'] = $input->email;			
			if($input->password != $user[0]['password'])
				 $data['password'] = password_hash($input->password, PASSWORD_DEFAULT);

			$user_id = $this->crud->update('users', $data, 'id=:user_id', [':user_id' => $id]);
			$this->crud->delete('group_user', 'user_id=:user_id', [':user_id' => $id]);
			$groups = $this->_groups();

			if(isset($input->groups))
			{
				foreach ($input->groups as $key => $value) 
				{
					if(isset($groups[$value]))
					$this->crud->create('group_user', ['user_id' => $id, 'group_id' => $value]);
				}
			}			

			return $this->singleuser(['id' => $id]);

		}
		else
		{
			exit(json_encode(['error' => 'Invalid JSON']));
		}


		
	}	

	public function allusers()
	{
		
		$users = $this->crud->read('users');
		exit(json_encode($users));
	}	

	public function singlegroup($params)
	{
		$id = $params['id'];
		$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);

		if(empty($group))
			exit(json_encode(['error' => 'Resource cannot be found']));

		exit(json_encode($group[0]));
	}

	public function allgroups()
	{
		
		$users = $this->crud->read('groups');
		exit(json_encode($users));
	}	


	public function creategroup()
	{

		if($input = json_decode(file_get_contents('php://input')))
		{
			if(!isset($input->name))
				exit(json_encode(['error' => 'Missing field name']));	

			$group_id = $this->crud->create('groups', ['name' => $input->name]);
			return $this->singlegroup(['id' => $group_id]);
		}
		else
		{
			exit(json_encode(['error' => 'Invalid JSON']));
		}

	}
	public function updategroup($params)
	{
		if($input = json_decode(file_get_contents('php://input')))
		{
			$id = $params['id'];
			$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);

			if(empty($group))
				exit(json_encode(['error' => 'Resource cannot be found']));

			if(!isset($input->name))
				exit(json_encode(['error' => 'Missing field name']));	

			$group_id = $this->crud->update('groups', ['name' => $input->name],'id=:group_id', [':group_id' => $id]);
			return $this->singlegroup(['id' => $group_id]);
		}
		else
		{
			exit(json_encode(['error' => 'Invalid JSON']));
		}

	}

	public function deleteuser($params)
	{
		$id = $params['id'];

		$user = $this->crud->read('users', 'id=:id', [':id' => $id]);

		if(empty($user))
			exit(json_encode(['error' => 'Resource cannot be found']));
		
		$this->crud->delete('users', 'id=:id', [':id' => $id]);
		$this->crud->delete('group_user', 'user_id=:id', [':id' => $id]);
		exit(json_encode(["success" => 1]));
	}

	public function deletegroup($params)
	{
		$id = $params['id'];



		$group = $this->crud->read('groups', 'id=:id', [':id' => $id]);

		if(empty($group))
			exit(json_encode(['error' => 'Resource cannot be found']));

		$this->crud->delete('groups', 'id=:id', [':id' => $id]);
		$this->crud->delete('group_user', 'group_id=:id', [':id' => $id]);
		exit(json_encode(["success" => 1]));
	}

}