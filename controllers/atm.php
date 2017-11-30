<?php require_once('../controllers/initialize.php'); ?>
<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  ../controllers/login.php");
	exit;
}

//Define variables to posted values if set
$account_no = isset($_POST['account_no']) ? $_POST['account_no'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';

$userID = $person['id'];
$bank = new BankAccount();
$accounts = $bank->select_by_id_type($userID);

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Get the bank ID from the account number
	$bank_id = $bank->get_bank_id($account_no);
	
	//Round amount to the nearest 2 decimal points
	$amount = round($amount, 2);
	
	//Validate form - ensure all required fields are completed appropriately
	$trans = new AccountTransaction();
	$validate = $trans->validate_user_transaction($bank_id, $amount, $type);
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{
		
		//Create array of values
		$transArray = ['bank_id' => $bank_id, 'trans_amt' => $amount, 'trans_date' => $date, 'trans_type' => $type];
		
		//Update the total balance
		$new_balance = $trans->get_new_balance($bank_id, $amount, $type);
		$update_array = ['balance' => $new_balance];
		$bank->update($update_array, $bank_id);
		
		//Insert the account transaction array into the database
		$trans->insert($transArray);

		//Route user to info page
		header("Location:  ../views/index.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>
<?php require_once('../views/atmForm.php'); ?>