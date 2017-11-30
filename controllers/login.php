<?php include_once('../controllers/initialize.php'); ?>
<?php

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$errors = "<br />";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$user = new User();

	$verify = $user->log_in($email, $password);

	if($verify){
		$person = $user->get_user_by_email($email);
		$person = $person[0];
		$personName = $person['first_name']." ".$person['last_name'];
		
		$_SESSION['userEmail'] = $email;
		$_SESSION['userName'] = $personName;
		
		header("Location:  ../views/login_review.php");
		exit;
		
	}else{
		$verify = false;
		$person = "";
		$errors = "Incorrect email or password.";
	}	
}else{
	$verify = false;
	$errors = "<br />";
}

?>
<?php include_once('../views/loginForm.php'); ?>