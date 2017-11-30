<?php
$userID = $person['id'];

//Instantiate new objects
$bank = new BankAccount();
$trans = new AccountTransaction();

//Get all bank accounts for logged in user
$accountInfo = $bank->select_by_id_type($userID);

//Find the number bank accounts
$length = count($accountInfo);

for($i = 0; $i < $length; $i++){
	$bank_id = $accountInfo[$i]['id'];
	
	//Get the last day that interest was calculated for the bank account
	$interest_dates = $trans->get_interest($bank_id);
	
	//Start date
	$startDate = new DateTime($interest_dates['startDate']);
	
	//Last Interest Date
	$lastInterest = new DateTime($interest_dates['lastInterest']);

	//If no interest has been added yet
	if(empty($interest_dates['lastInterest'])){
		//Get the date difference from the start date of the account
		$date_difference = get_date_difference($startDate);
		
		//Add the interest to the database
		apply_interest($date_difference, $startDate, $bank_id, $bank, $trans);
		
	}else{
		//Get the date difference from the most recent interest date of the account
		$date_difference = get_date_difference($lastInterest);
		
		//Add the interest to the database
		apply_interest($date_difference, $lastInterest, $bank_id, $bank, $trans);
	}

}



?>