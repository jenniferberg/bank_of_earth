<?php require_once('../controllers/initialize.php'); ?>
<?php 
$user = new User();
$bank = new BankAccount();
$trans = new AccountTransaction();
?>
<?php include_once('../views/layouts/header.php'); ?>

<div class="message1">Wait one moment while we finalize your account...</div>
<div class="message2">Welcome to Bank of Earth!</div>
<?php include_once('../views/layouts/footer.php');?>	
<?php
if(isset($_SESSION['emailArray']) && isset($_SESSION['infoArray']) && isset($_SESSION['acctArray'])){
	
	//Define variables based on session arrays
	$email = $_SESSION['emailArray'];
	$info = $_SESSION['infoArray'];
	$bankArray = $_SESSION['acctArray'];
	
	//Combine email and info arrays into one array
	$userArray = [];
	foreach($info as $key => $value){
		$userArray[$key] = $value;
	}
	foreach($email as $key => $value){
		$userArray[$key] = $value;
	}
	
	//Define variable for account type
	$type = $bankArray["type"];
	
	//Get new account number
	$account_no = $bank->get_next_acct($type);
	
	//Add new account number to the bank array
	$bankArray['account_no'] = $account_no;
	
	//Insert user array into the database
	$user->insert($userArray);
	
	//Get the newly added user ID
	$user_id = $db->get_id();
	
	//Add the user ID to the bank array
	$bankArray['user_id'] = $user_id;
	
	//Insert the bank array into the database
	$bank->insert($bankArray);
	
	//Get the newly added bank ID
	$bank_id = $db->get_id();

	//Define the accuont transaction array
	$transArray = ['bank_id' => $bank_id, 'trans_amt' => $bankArray['balance'],
					'trans_date' => $date, 'trans_type' => 'Initial Deposit'];
	
	//Insert the account transaction array into the database
	$trans->insert($transArray);
	
	//Set the new session user email and name variables
	$_SESSION['userEmail'] = $userArray['email'];
	$_SESSION['userName'] = $userArray['first_name']." ".$userArray['last_name'];
	
	//Unset the session arrays
	unset($_SESSION['infoArray']);
	unset($_SESSION['emailArray']);
	unset($_SESSION['acctArray']);
	
	//Route the user to the main page
	header("Refresh: 11; url=../views/index.php");
	exit;
	
}else{
	header("Location: login.php");
	exit;
}
?>
