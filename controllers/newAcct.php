<?php include_once('../controllers/initialize.php'); ?>
<?php
$acctArray = isset($_SESSION['acctArray']) ? $_SESSION['acctArray'] : [];
//Define form type
$formType = 'new';

//Define variables to posted values if set
$type = isset($_POST['type']) ? $_POST['type'] : (isset($acctArray['type']) ? $acctArray['type'] : '');
$amount = isset($_POST['amount']) ? $_POST['amount'] : (isset($acctArray['balance']) ? $acctArray['balance'] : '');

//If the Session email and info arrays are not set from the previous form, reroute
if(!isset($_SESSION['emailArray']) || !isset($_SESSION['infoArray'])){
	header("Location:  ../views/index.php");
	exit;
}

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Validate form - ensure all required fields are completed
	$account = new BankAccount();
	$validate = $account->validate_user_acct($amount);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{	
		//Create array of values
		$user_array = ['type' => $type, 'balance' => $amount];
		
		//Set session variable to array
		$_SESSION['acctArray'] = $user_array;
		
		//Route user to info page
		header("Location:  submit.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formAcct.php'); ?>	

