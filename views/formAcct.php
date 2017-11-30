<?php include_once('../views/layouts/header.php'); ?>
<?php
if($formType == 'edit'){
	$submit = 'Submit';
	$action = '../views/info.php';
	$tableClass = 'formReview';
}elseif($formType == 'new'){
	$submit = 'Next';
	$action = '../controllers/logout.php';
	$back = '../controllers/newInfo.php';
	$tableClass = 'form';
}else{
	$submit = 'Submit';
	$action = 'index.php';
	$tableClass = 'formReview';
}

?>
<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['acctArray'])){
?>
<div class="message1">Great!  We're almost done.</div>
<div class="message2">Now, let's pick a type of account and make a deposit.</div>
<?php 
} ?>
<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET'  && !isset($_SESSION['acctArray'])){
?>
	<div class="fadeTimer center colorLight">
<?php 
}else{
?>
	<div class="center colorLight">
<?php 
}
?>
<h3 class="colorLight">Account Information</h3>
<div class="instructions center">
  Minimum deposit of $25 is required.
  <br />
  Amounts will be rounded to the nearest 2 decimal points.
</div>
<?php if(isset($validate) && !empty($validate)){ ?> 
<div class="error">
  <?php echo $errors; ?>
  <ul>
  <?php
  if(isset($validate)){
	foreach($validate as $field => $error){
	  if(isset($validate[$field])){
		  echo "<li class=\"left\">".$validate[$field]."</li>";
	  }
    }
  }
  ?>
  </ul>
</div>
<?php } ?>
<form method="POST">
<table class="<?php echo $tableClass; ?>">
  <tr>
    <th class="right highlight">Type of Account:</th>
    <td class="left"><select name="type">
	  <option value="Checking" <?php echo $type == "Checking" ? 'selected' : ''; ?>>Checking</option>
	  <option value="Savings" <?php echo $type == "Savings" ? 'selected' : ''; ?>>Savings</option>
	</td>
  </tr>
  <tr>
    <th class="right highlight">Initial Deposit Amount:</th>
	<td class="left"><input id="amount" type="text" name="amount" value="<?php echo $amount; ?>" onkeypress="return dollar_format();"/></td>
  </tr>
</table>
<div>
<?php if(($formType == 'new')){ ?>
	<a href="<?php echo $back; ?>" class="block buttonLink">Back</a>
<?php } ?>
	<input class="button" type="submit" name="submit" value="<?php echo $submit; ?>" />
	<a href="<?php echo $action; ?>" class="block buttonLink" onclick="return confirm('Are you sure you want to cancel?')">Cancel</a>
</form>
</div>
</div>

<?php include_once('../views/layouts/footer.php');?>	

<script>
var input = document.getElementById("amount");

function dollar_format(){
	var result = input.value;
	console.log("result = "+result);

	//If nothing has been typed
	if(!result){
		//If input is 0 or a decimal, do not allow
		if((event.charCode == 48 || event.charCode == 46)){
			return event.charCode >= 49 && event.charCode <= 57;
		}else{
			//i = 1;
			return event.charCode >= 49 && event.charCode <= 57;
		}
		
	}
	//If a decimal is typed and there is not already a decimal
	else if(event.charCode == 46 && result.indexOf('.') < 0){
		return event.charCode == 46;
	}
	//Else, allow numbers only
	else{
		return event.charCode >= 48 && event.charCode <= 57;
	}
	
	
}


</script>