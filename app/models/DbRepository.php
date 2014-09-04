<?php

namespace Zitcom\Models;

class DbRepository
{
	
	protected $conn;
	protected $datafields = [];

	public function __construct()
	{

		$config = require app_path()."/config/database.php";
		$this->conn = new \mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
		$this->conn->set_charset($config['charset']);

        if (mysqli_connect_errno()) 
    		throw new Exception("Connect failed: ", mysqli_connect_error(), 1);
		
	}

	public static function find($id)
	{		
		$parts = explode("\\", get_called_class());
		$table = strtolower(array_pop($parts))."s";		
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE id = ? LIMIT 1");
			$stmt->bind_param('i', $id);
			$stmt->execute();

			if($stmt->num_rows > 0)
			{
				$result = $stmt->get_result();
				$datafields = $result->fetch_assoc();
				$obj = new get_called_class();
				$obj->set_datafields($datafields);
				return $obj;
			}

			throw new Exception('Model not found', 1);
		}
	}

	public function set_datafields($datafields)
	{
		$this->datafields = $datafields;
	}


}