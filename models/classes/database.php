<?php
//Define database constants
//Complete the '...' with your own user and password
const DB_HOST = 'localhost';
const DB_USER = '...';
const DB_PASS = '...';
const DB_NAME = 'bank_of_earth';

//Database class
class Database{
	
	private $connection;
	
	function __construct(){
		$this->db_open();
	}
	
	//Connect to the database
	public function db_open(){
		$this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		
		//Test if connection occured or if there are errors
		if(mysqli_connect_errno()){
			die("Database connection failed.");
			return false;
		}else{
			return true;
		}
	}
	
	//Database query
	public function db_query($sql){
		$result = mysqli_query($this->connection, $sql);
		
		if(!$result){
			die("Database query failed.");
			return false;
		}else{
			return $result;
		}
	}
	
	//Escape strings to protect against SQL injection
	public function escape_string($string){
		return mysqli_real_escape_string($this->connection, $string);
	}
	
	//Return data
	public function db_fetch_assoc($result){
		return mysqli_fetch_assoc($result);
	}
	
	//Get most recent inserted record
	public function get_id(){
		return mysqli_insert_id($this->connection);
	}
	
	//Close database connection
	public function db_close(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
		}
	}
	
}

$db = new Database();

?>