<?php require_once('../controllers/initialize.php'); ?>
<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  login.php");
	exit;
}
?>
<?php
//Define form type
$formType = 'edit';

$errors = "<br />";
$email = isset($_POST['email']) ? $_POST['email'] : $person['email'];
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';


//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Validate form
	$validate = $user->validate_user_email($email, $password, $confirm_password, $person['id']);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{
		//Hash password
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		
		//Create array of values
		$user_array = ['email' => $email, 'password' => $hashed_password];
		
		//Update user information in the database
		$user->update($user_array, $person['id']);
		
		//Log user out
		header("Location:  logout.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formEmail.php'); ?>	