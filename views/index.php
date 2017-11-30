<?php require_once('../controllers/initialize.php'); ?>
<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  ../controllers/login.php");
	exit;
}

//Instantiate new BankAccount object
$account = new BankAccount();

$accountInfo = $account->select_by_id_type($person['id']);

//Number of accounts
$lengthA = count($accountInfo);

?>

<?php include_once('../views/layouts/header.php'); ?>
<div class="instructions center"><?php echo "Grand Total For All Accounts:  $". number_format($account->get_grand_total($person['id']), 2); ?></div>
<div class="center">
	<a href="../controllers/addAcct.php" class="block buttonLink">Add New Bank Account</a>
  <?php if($lengthA > 1){ ?>
	<a href="../controllers/transfer.php" class="block buttonLink">Transfer Funds</a>
  <?php }
  ?>
</div>
<br />
<div class="instructions center">Select an account number to view its transaction history.</div>
<div class="center">
<?php


for($i = 0; $i < $lengthA; $i++){
	$bank_id = $accountInfo[$i]['id'];
	$account_no = $accountInfo[$i]['account_no'];
	$balance = number_format($accountInfo[$i]['balance'], 2);
	$type = $accountInfo[$i]['type'];
	
	//echo "<input type=\"checkbox\" name=\"account\" value=\"{$bank_id}\" onChange=\"this.form.submit()\">";
	//echo $bank_id;
?>	
<div class="accounts block">
	<form name="accountForm" method="POST" action="accounts.php">
	  <input type="hidden" name="bank_id" value="<?php echo $bank_id; ?>" />
		<button class="accountsButton">
		  <?php echo $type." Account:  ".$account_no; ?><br />
		  <?php echo "Current Balance:  $".$balance; ?> 
		</button>
	</form>
  </div>

  
<?php
}
?>

</div>
<?php include_once('../views/layouts/footer.php'); ?>	


