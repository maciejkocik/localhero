<?php

//Connection ----------------------------------------------------
class DBConnect
{
	private $name_user_db = 'root';
	private $password_user_db = '';
	private $host = '127.0.0.1';
	private $db_name = 'localheroe';
	private static $connectionGlobal = false;
	private static $resultConnectionGlobal;
	public $connection;
	public $resultConnection;

	
	public function __construct()
	{
		
			if(DBConnect::$connectionGlobal === false)
			{
				try
				{
					DBConnect::$connectionGlobal = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8',$this->name_user_db,$this->password_user_db);
					DBConnect::$resultConnectionGlobal = true;
				}
				catch(PDOException $e)
				{
					DBConnect::$resultConnectionGlobal = false;
				}
			}
			//$this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8',$this->name_user_db,$this->password_user_db);
			$this->connection = DBConnect::$connectionGlobal;
			$this->resultConnection = DBConnect::$resultConnectionGlobal;
		
	}
	public function __destruct()
	{
		try
		{
			unset($this->connection);
			//$this->connection = null;
		}
		catch(PDOException $e)
		{
			
		}
	}
}

?>