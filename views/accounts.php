<?php
require_once('../controllers/initialize.php');

if(!isset($userEmail) || empty($userEmail)){
	header("Location:  login.php");
	exit;
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	header("Location:  index.php");
	exit;	
}

$bank_id = isset($_POST['bank_id']) ? $_POST['bank_id'] : '';

//Instantiate new objects
$bank = new BankAccount();
$transaction = new AccountTransaction();

$details = $transaction->select_by_id_type($bank_id);

$bankInformation = $bank->select_by_id($bank_id)[0];
$accountNo = $bankInformation['account_no'];
$accountType = $bankInformation['type'];
$balance = number_format($bankInformation['balance'], 2);

?>
<?php include_once('../views/layouts/header.php'); ?>
<div class="instructions center">
  <?php echo "{$accountType} Account {$accountNo}<br />"; 
		echo "Current Balance :  $ {$balance}";
  ?>
</div>
<div class="transactionsBlock">
<table class="transactions">
  <th>Date</th>
  <th>Type</th>
  <th>Credits</th>
  <th>Debits</th>
<?php
$length = count($details);

for($i = 0; $i < $length; $i++):
	$trans_type = $details[$i]['trans_type'];
	
	$trans_date = strtotime($details[$i]['trans_date']);
	$trans_date = strftime('%m/%d/%Y', $trans_date);
	
	$trans_amt = "$".number_format($details[$i]['trans_amt'], 2);
?>
	<tr>
	  <td class="left"><?php echo $trans_date; ?></td>
	  <td class="left"><?php echo $trans_type; ?></td>
	  <td class="right"><?php echo $trans_type != 'Withdrawal' && $trans_type != 'Transfer Withdrawal' ? $trans_amt : '' ; ?></td>
	  <td class="right"><?php echo $trans_type == 'Withdrawal' || $trans_type == 'Transfer Withdrawal' ? $trans_amt : ''; ?></td>
	</tr>
<?php	
endfor;
?>
</table>
</div>

<?php include_once('../views/layouts/footer.php'); ?>	