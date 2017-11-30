<?php
//Array of state abbreviations
$states = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 
			'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS',
			'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK',
			'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV',
			'WI', 'WY'];
			
//Calculate the difference between now and date input
function get_date_difference($date_input){
	$now = new DateTime();
	
	$difCalc = $date_input->diff($now);
	$difference = $difCalc->format('%R%a days');
	
	return $difference;
}

//Determine how many 
function get_days_counter($days){
	$multipleDays = $days/30;
	$multipleDays = floor($multipleDays);
	
	return $multipleDays;

}

//Input the interest into the database
function apply_interest($date_difference, $last_date, $bank_id, $bank_object, $trans_object){
	//If more than 30 days has passed since the last interest was inputted
	if($date_difference >= 30){
		$multipleDays = get_days_counter($date_difference);
		$counter = $multipleDays + 1;
		
		for($j = 1; $j < $counter; $j++){
			//output the newly calculated interest value, balance, and date
			$interest_output = $bank_object->output_interest($last_date, $bank_id);
			
			//Create array of values for the bank account
			$bankArray = ['balance' => $interest_output['new_balance']];
			
			//Update the bank account in the database
			$bank_object->update($bankArray, $interest_output['id']);

			//Define the account transaction array
			$transArray = ['bank_id' => $interest_output['id'], 'trans_amt' => $interest_output['calculated_interest'],
							'trans_date' => $interest_output['newInterestDate'], 'trans_type' => 'Interest'];
			
			//Insert the account transaction array into the database
			$trans_object->insert($transArray);

		}
		return true;
	}else{
		return false;
	}
}

?>