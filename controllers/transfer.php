<?php require_once('../controllers/initialize.php'); ?>
<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  ../controllers/login.php");
	exit;
}

//Define variables to posted values if set
$account_no_from = isset($_POST['account_no_from']) ? $_POST['account_no_from'] : '';
$account_no_to = isset($_POST['account_no_to']) ? $_POST['account_no_to'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';

$userID = $person['id'];
$bank = new BankAccount();
$accounts = $bank->select_by_id_type($userID);

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Get the bank IDs from the account numbers
	$bank_id_from = $bank->get_bank_id($account_no_from);
	$bank_id_to = $bank->get_bank_id($account_no_to);
	
	$typeFrom = 'Transfer Withdrawal';
	$typeTo = 'Transfer Deposit';
	
	//Round amount to the nearest 2 decimal points
	$amount = round($amount, 2);
	
	//Validate form - ensure all required fields are completed appropriately
	$trans = new AccountTransaction();
	$validate = $trans->validate_transfer_transaction($bank_id_from, $amount, $typeFrom);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{
		
		//Create arrays of values
		$transFrom = ['bank_id' => $bank_id_from, 'trans_amt' => $amount, 'trans_date' => $date, 'trans_type' => $typeFrom];
		$transTo = ['bank_id' => $bank_id_to, 'trans_amt' => $amount, 'trans_date' => $date, 'trans_type' => $typeTo];
		
		//Update the total balances
		$new_balance_from = $trans->get_new_balance($bank_id_from, $amount, $typeFrom);
		$new_balance_to = $trans->get_new_balance($bank_id_to, $amount, $typeTo);
		
		$update_array_from = ['balance' => $new_balance_from];
		$update_array_to = ['balance' => $new_balance_to];
		
		$bank->update($update_array_from, $bank_id_from);
		$bank->update($update_array_to, $bank_id_to);
		
		//Insert the account transaction arrays into the database
		$trans->insert($transFrom);
		$trans->insert($transTo);

		//Route user to info page
		header("Location:  ../views/index.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>
<?php require_once('../views/transferForm.php'); ?>