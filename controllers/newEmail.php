<?php include_once('../controllers/initialize.php'); ?>
<?php
$emailArray = isset($_SESSION['emailArray']) ? $_SESSION['emailArray'] : [];
//Define form type
$formType = 'new';

$errors = "<br />";
$email = isset($_POST['email']) ? $_POST['email'] : (isset($emailArray['email']) ? $emailArray['email'] : '');
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';


//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Validate form
	$user = new User();
	$validate = $user->validate_user_email($email, $password, $confirm_password);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{
		//Hash password
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		
		//Create array of values
		$user_array = ['email' => $email, 'password' => $hashed_password];
		
		//Set session variable to array
		$_SESSION['emailArray'] = $user_array;
		
		//Route user to add new personal information
		header("Location:  newInfo.php");
		exit;
		
	}
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formEmail.php'); ?>	