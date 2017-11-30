<?php include_once('../views/layouts/header.php'); ?>
<div class="instructions center">

  Minimum transfer of $25 is required.
  <br />
  Account must have a remaining balance of at least $25.
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
<div class="center">
<form method="POST">
<table class="formReview">
  <tr>
    <th class="right">Transfer From Account Number:</th>
	<td class="left"><select name="account_no_from">
	<?php
	$count = count($accounts);
	for($i = 0; $i < $count; $i++){
		echo "<option value=\"{$accounts[$i]['account_no']}\"";
		if($account_no_from == $accounts[$i]['account_no']){
			echo ' selected';
		}
		echo ">";
		echo $accounts[$i]['type']." Account ".$accounts[$i]['account_no']."<br />";
		echo "</option>";
	}
	?>
	</select></td>
  </tr>
  <tr>
    <th class="right">Transfer To Account Number:</th>
	<td class="left"><select name="account_no_to">
	<?php
	$count = count($accounts);
	for($i = 0; $i < $count; $i++){
		echo "<option value=\"{$accounts[$i]['account_no']}\"";
		if($account_no_to == $accounts[$i]['account_no']){
			echo ' selected';
		}
		echo ">";
		echo $accounts[$i]['type']." Account ".$accounts[$i]['account_no']."<br />";
		echo "</option>";
	}
	?>
	</select></td>
  </tr>
  <tr>
    <th class="right">Transaction Amount:</th>
	<td class="left"><input id="amount" type="text" name="amount" value="<?php echo $amount; ?>" onkeypress="return dollar_format();"/></td>
  </tr>
</table>
<div>
  <input class="button" type="submit" name="submit" value="Submit" />
  <a href="<?php echo $action; ?>" class="block buttonLink" onclick="return confirm('Are you sure you want to cancel?')">Cancel</a>
</form>
</div>
</div>
<?php include_once('../views/layouts/footer.php');?>	

<script>
var input = document.getElementById("amount");

function dollar_format(){
	var result = input.value;

	//If nothing has been typed
	if(!result){
		//If input is 0 or a decimal, do not allow
		if((event.charCode == 48 || event.charCode == 46)){
			return event.charCode >= 49 && event.charCode <= 57;
		}else{
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
	
	
	if(result.indexOf('.') >= 0){
		console.log("decimal");
	}
}

</script>