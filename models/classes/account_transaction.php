<?php
require_once("database.php");
require_once("database_queries.php");
require_once("../models/functions/validation_functions.php");

class AccountTransaction extends DatabaseQueries{
	
	protected static $tableName="AccountTransactions";
	protected static $id_type="bank_id";
	protected static $orderBy="trans_date";
	
	private static $requiredAcct = ['account_no', 'type', 'amount'];
	private static $requiredTransfer = ['account_no_from', 'account_no_to','amount'];
	private static $maxTransfer = ['account_no_from'=>10, 'account_no_to'=>10, 'amount'=>10];
	private static $maxAcct = ['account_no'=>10, 'type'=>50, 'amount'=>10];
	private static $minAcct = ['amount'=>2];
	
	private $id;
	private $bank_id;
	private $trans_amt;
	private $trans_date;
	private $trans_type;
	
	public function sum_of_transactions($bank_id){
		global $db;
		
		$sql  = "SELECT (credits.credit + debits.debit) as sum FROM ";
		$sql .= "(SELECT sum(trans_amt) as credit FROM AccountTransactions ";
		$sql .= "WHERE bank_id = '".$bank_id."' ";
		$sql .= "AND trans_type not in ('Withdrawal', 'Transfer Withdrawal') ";
		$sql .= ") as credits, ";
		$sql .= "(SELECT CASE ";
		$sql .= " WHEN ISNULL(trans_amt) THEN 0 ";
		$sql .= " ELSE -sum(trans_amt) ";
		$sql .= "END as debit FROM AccountTransactions ";
		$sql .= "WHERE bank_id = '".$bank_id."' ";
		$sql .= "AND trans_type in ('Withdrawal', 'Transfer Withdrawal') ";
		$sql .= ") as debits ";
		
		$result = $this->return_output($sql);

		$sum = $result[0]['sum'];
		
		return $sum;
	}
	
	public function get_new_balance($id, $amount, $type){
		$balance = $this->sum_of_transactions($id);
		
		if($type == "Withdrawal" || $type == "Transfer Withdrawal" ){
			$new_balance = $balance - $amount;
		}else{
			$new_balance = $balance + $amount;
		}
		return $new_balance;
	}
	
	public function get_interest($bank_id){
		global $db;
		
		$sql  =  "SELECT trans_date as last_interest FROM AccountTransactions";
		$sql .=  "	WHERE bank_id = '".$bank_id."'";
		$sql .=  "	AND trans_type = 'Interest'";
		$sql .=  "	ORDER BY trans_date desc";
		$sql .=  "	LIMIT 1";
		
		$result = $this->return_output($sql);
		if($result){
			$lastInterest = $result[0]['last_interest'];
		}else{
			$lastInterest = '';
		}
		
		
		$sql  =  "SELECT trans_date as start_date FROM AccountTransactions";
		$sql .=  "	WHERE bank_id = '".$bank_id."'";
		$sql .=  "	ORDER BY trans_date asc";
		$sql .=  "	LIMIT 1";
		
		$result = $this->return_output($sql);
		$startDate = $result[0]['start_date'];
		
		$interestResults = ['lastInterest' => $lastInterest, 'startDate' => $startDate];
	
		return $interestResults;
	
	}
	
	public function validate_user_transaction($bank_id, $amount, $type){
		$message = validate_info(self::$requiredAcct, self::$minAcct, self::$maxAcct);
		
		if($amount < 25){
			if(isset($message['amount'])){
				$message['amount'] .= "Amount must be at least $25.";
			}else{
				$message['amount'] = "Amount must be at least $25.";
			}
		}
		
		$new_balance = $this->get_new_balance($bank_id, $amount, $type);
		
		if($new_balance < 25){
			if(isset($message['amount'])){
				$message['amount'] .= "Remaining balance must be at least $25.";
			}else{
				$message['amount'] = "Remaining balance must be at least $25.";
			}
		}
		
		return $message;
		
	}
	
	public function validate_transfer_transaction($bank_id, $amount, $type){
		$message = validate_info(self::$requiredTransfer, self::$minAcct, self::$maxTransfer);
		
		if($amount < 25){
			if(isset($message['amount'])){
				$message['amount'] .= "Amount must be at least $25.";
			}else{
				$message['amount'] = "Amount must be at least $25.";
			}
		}
		
		$new_balance = $this->get_new_balance($bank_id, $amount, $type);
		
		if($new_balance < 25){
			if(isset($message['amount'])){
				$message['amount'] .= "Remaining balance must be at least $25.";
			}else{
				$message['amount'] = "Remaining balance must be at least $25.";
			}
		}
		
		return $message;
	}
}


?>