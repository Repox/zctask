<?php

namespace Zitcom\Models;

class Crud
{

	protected $db;

    function __construct() 
    {
        $options = array(
            \PDO::ATTR_PERSISTENT => true, 
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        $config = require app_path()."/config/database.php";

        try {
            
            $this->db = new \PDO("mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['charset']}", $config['username'], $config['password'], $options);
            
        } catch(PDOException $e) {
            echo $e->getMessage(); exit(1);
        }
    }

    function run($sql, $bind=array()) 
    {
        $sql = trim($sql);
        
        try {

            $result = $this->db->prepare($sql);
            $result->execute($bind);
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage(); exit(1);
        }
    }

    function create($table, $data) 
    {
        $fields = $this->filter($table, $data);

        $sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";

        $bind = array();
        foreach($fields as $field)
            $bind[":$field"] = $data[$field];

        $result = $this->run($sql, $bind);
        return $this->db->lastInsertId();
    }

    function read($table, $where="", $bind=array(), $fields="*") 
    {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if(!empty($where))
            $sql .= " WHERE " . $where;
        $sql .= ";";

        $result = $this->run($sql, $bind);
        $result->setFetchMode(\PDO::FETCH_ASSOC);

        $rows = array();
        while($row = $result->fetch()) {
            $rows[] = $row;
        }

        return $rows;
    }

    function update($table, $data, $where, $bind=array()) 
    {
        $fields = $this->filter($table, $data);
        $fieldSize = sizeof($fields);

        $sql = "UPDATE " . $table . " SET ";
        for($f = 0; $f < $fieldSize; ++$f) {
            if($f > 0)
                $sql .= ", ";
            $sql .= $fields[$f] . " = :update_" . $fields[$f]; 
        }
        $sql .= " WHERE " . $where . ";";

        foreach($fields as $field)
            $bind[":update_$field"] = $data[$field];
        
        $result = $this->run($sql, $bind);
        return $result->rowCount();
    }

    function delete($table, $where, $bind="") 
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        $result = $this->run($sql, $bind);
        return $result->rowCount();
    }

    private function filter($table, $data) 
    {
    
         $sql = "DESCRIBE " . $table . ";";
         $key = "Field";
       
        if(false !== ($list = $this->run($sql))) {
            $fields = array();
            foreach($list as $record)
                $fields[] = $record[$key];
            return array_values(array_intersect($fields, array_keys($data)));
        }

        return array();
    }
}