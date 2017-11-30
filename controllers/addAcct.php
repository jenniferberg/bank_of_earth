<?php require_once('../controllers/initialize.php'); ?>
<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  login.php");
	exit;
}

?>
<?php
//Define form type
$formType = '';

//Define variables to posted values if set
$user_id = $person['id'];
$type = isset($_POST['type']) ? $_POST['type'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Instantiate new BankAccount object
	$bank = new BankAccount();
	
	//Validate form - ensure all required fields are completed
	$validate = $bank->validate_user_acct($amount);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{	
		//Get new account number
		$account_no = $bank->get_next_acct($type);
	
		//Create array of values for new bank account
		$bankArray = ['user_id' => $user_id, 'account_no' => $account_no, 'type' => $type, 'balance' => $amount];
		
		//Insert the bank array into the database
		$bank->insert($bankArray);
		
		//Get the newly added bank ID
		$bank_id = $db->get_id();
		
		//Instantiate new AccountTransaction object
		$trans = new AccountTransaction();

		//Define the accuont transaction array
		$transArray = ['bank_id' => $bank_id, 'trans_amt' => $amount,
						'trans_date' => $date, 'trans_type' => 'Initial Deposit'];
		
		//Insert the account transaction array into the database
		$trans->insert($transArray);
		
		//Route user to main page
		header("Location:  ../views/index.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formAcct.php'); ?>	

