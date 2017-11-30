<?php
require_once("database.php");
require_once("database_queries.php");
require_once("../models/functions/validation_functions.php");

class BankAccount extends DatabaseQueries{
	
	protected static $tableName="BankAccounts";
	protected static $id_type="user_id";
	protected static $orderBy="type";
	private static $interestRate="0.0005";
	
	private static $requiredAcct = ['type', 'amount'];
	private static $maxAcct = ['type'=>10, 'amount'=>10];
	private static $minAcct = ['amount'=>2];
	
	private $id;
	private $user_id;
	private $account_no;
	private $type;
	private $balance;
	
	public function get_grand_total($user_id){
		global $db;
		
		$sql  = "SELECT sum(balance) as grand_total FROM ".static::$tableName;
		$sql .= " WHERE user_id = '".$user_id."'";
		$sql .= " LIMIT 1";
		
		$result = $this->return_output($sql);
		$grand_total = $result[0]['grand_total'];
		
		return $grand_total;
	}
	
	public function calculate_interest($balance){
		$new_balance = $balance * (1 + self::$interestRate);
		
		return $new_balance;
	}
	
	public function output_interest($date_input, $bank_id){
		//Get the current bank account balance
		$reCalc = $this->select_by_id($bank_id);
		$id = $reCalc[0]['id'];
		$balance = $reCalc[0]['balance'];
		
		//Get the new balance with added interest
		$new_balance = $this->calculate_interest($balance);
		
		//Get the added interest
		$calculated_interest = $new_balance - $balance;
		
		//Round all numbers to nearest 2 decimal points
		$new_balance = round($new_balance, 2);
		$balance = round($balance, 2);
		$calculated_interest = round($calculated_interest, 2);
		
		//Determine interest date based on inputed date
		$newIntCalc = $date_input->add(new DateInterval('P30D'));
		$newInterestDate = $newIntCalc->format('Y-m-d H:i:s');	
		
		$output = ['id' => $id, 'new_balance' => $new_balance, 'calculated_interest' => $calculated_interest, 'newInterestDate' => $newInterestDate];
		
		return $output;
	}
	
	public function validate_user_acct($amount){
		$message = validate_info(self::$requiredAcct, self::$minAcct, self::$maxAcct);
		
		//Rounds amount to nearest 2 decimal points
		$amount = round($amount, 2);
		
		if($amount < 25){
			if(isset($message['amount'])){
				$message['amount'] .= "Amount must be at least $25.";
			}else{
				$message['amount'] = "Amount must be at least $25.";
			}
		}
		
		return $message;
	}
	
	public function get_next_acct($type){
		global $db;
		
		$sql  = "SELECT max(id) as id FROM ".self::$tableName;
		$sql .= " WHERE type = '".$type."'";
		
		$idResult = $this->return_output($sql)[0];
		$id = $idResult['id'];
		
		$sql  = "SELECT account_no FROM ".self::$tableName;
		$sql .= " WHERE type = '".$type."'";
		$sql .= " AND id = '".$id."'";
		
		$acctResult = $this->return_output($sql)[0];
		$account = $acctResult['account_no'];
		
		$next_acct = $account + 1;
		
		return $next_acct;
	}
	
	public function get_bank_id($account_no){
		global $db;
		
		$sql  = "SELECT id FROM ".self::$tableName;
		$sql .= " WHERE account_no = '".$account_no."'";
		
		$result = $this->return_output($sql)[0];
		$bank_id = $result['id'];
		
		return $bank_id;
	}
	
}

?>