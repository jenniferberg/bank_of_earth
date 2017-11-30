<?php

class Session{
	
	function __construct(){
		//turn on output buffering
		ob_start();
		
		//start the session
		session_start();
	}
	
	public function end_session(){
		//Unset session variables
		unset($_SESSION['userEmail']);
		unset($_SESSION['userName']);
		unset($_SESSION['infoArray']);
		unset($_SESSION['emailArray']);
		unset($_SESSION['acctArray']);
		
		//Destroy session
		session_destroy();
	}
	
}

$session = new Session();

?>