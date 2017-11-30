<?php
require_once("database_queries.php");
require_once("../models/functions/validation_functions.php");

class User extends DatabaseQueries{
	
	protected static $tableName="Users";
	//Arrays of required fields
	private static $requiredInfo = ['first_name', 'last_name', 'phone_country_code', 'phone_area_code', 'phone_prefix', 'phone_line_number', 'street_number', 'street', 'city', 'state', 'zipcode'];
	private static $requiredUser = ['email', 'password', 'confirm_password'];
	
	//Arrays of fields with max inputs
	private static $maxInfo = ['first_name'=>50, 'last_name'=>50, 'phone_country_code'=>2, 'phone_area_code'=>3, 'phone_prefix'=>3, 'phone_line_number'=>4, 'street_number'=>8, 'street'=>50, 'city'=>50, 'state'=>50, 'zipcode'=>10];
	private static $maxUser = ['email'=>60, 'password'=>255];
	
	//Arrays of fields with min inputs
	private static $minInfo = ['phone_country_code'=>2, 'phone_area_code'=>3, 'phone_prefix'=>3, 'phone_line_number'=>4, 'zipcode'=>5];
	private static $minUser = ['password'=>8];
	
	//Arrays of fields that must be integers
	private static $integers = ['phone_country_code', 'phone_area_code', 'phone_prefix', 'phone_line_number', 'street_number', 'zipcode'];
	
	private $id;
	private $first_name;
	private $last_name;
	private $phone;
	private $email;
	private $password;
	private $street_number;
	private $street;
	private $unit;
	private $city;
	private $state;
	private $country;
	private $zipcode;

	public function get_user_by_email($email){
		global $db;
		
		//Protect against SQL injection
		$email = $db->escape_string($email);
		
		$sql  = "SELECT * FROM ".self::$tableName;
		$sql .= " WHERE email = '".$email."' ";
		
		return $this->return_output($sql);
	}
	
	public function log_in($email, $password){
		global $db;
		
		$user = $this->get_user_by_email($email)[0];
		
		if($user){
			$verify = password_verify($password, $user['password']);
			
			return $verify ? true : false;
			
		}else{
			return false;
		}
		
	}
	
	public function does_email_exist($email, $id=0){
		global $db;
		
		//Protect against SQL injection
		$email = $db->escape_string($email);
		
		$sql  = "SELECT count(*) as count FROM ".self::$tableName;
		$sql .= " WHERE email = '".$email."' ";
		$sql .= " AND id <> '".$id."'";
		
		$email_exists = $this->return_output($sql);
		
		$message = [];
		
		if($email_exists[0]["count"] != 0){
			$message[] = "There is already an account for email {$email}. Please choose a different email address.";
			return $message;
		}else{
			return false;
		}
	}
	
	public function validate_user_info(){	
		return validate_info(self::$requiredInfo, self::$minInfo, self::$maxInfo, self::$integers);	
	}
	
	public function validate_user_email($email, $password, $confirm_password, $id=0){
		
		$message = validate_info(self::$requiredUser, self::$minUser, self::$maxUser);
		
		//Check that the email is in valid format
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)){
			if(isset($message['email'])){
				$message['email'] .= "Email is not formatted correctly.";
			}else{
				$message['email'] = "Email is not formatted correctly.";
			}
		}
		
		//Check that the email address does not already exist for a different user
		$emailCheck = $this->does_email_exist($email, $id);
		if($emailCheck){
			$message['email'] = $emailCheck;
		}
		
		//Check that the passwords match
		$match = match($password, $confirm_password);
		if(!$match){
			if(isset($message['confirm_password'])){
				$message['confirm_password'] .= "Password and Confirm Password do not match.";
			}else{
				$message['confirm_password'] = "Password and Confirm Password do not match.";
			}
		}
		
		return $message;
	}
	
	
}

	

?>