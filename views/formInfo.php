<?php include_once('../views/layouts/header.php'); ?>
<?php
if($formType == 'edit'){
	$submit = 'Submit';
	$action = '../views/info.php';
	$tableClass = 'formReview';
}elseif($formType == 'new'){
	$submit = 'Next';
	$action = '../controllers/logout.php';
	$back = '../controllers/newEmail.php';
	$tableClass = 'form';
}
?>
<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['infoArray'])){
?>
<div class="message1">Excellent, your email and password have been approved!</div>
<div class="message2">Next, let's set up some personal information.</div>
<?php 
} ?>
<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['infoArray'])){
?>
	<div class="fadeTimer center">
<?php 
}else{
?>
	<div class="center">
<?php 
}
?>
<h3 class="colorLight">Personal Information</h3>
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
    <th class="right highlight">First Name:</th>
	<td class="left"><input type="text" name="first_name" value="<?php echo $first_name; ?>" /></td>
  </tr>
  <tr>
    <th class="right highlight">Last Name:</th>
	<td class="left"><input type="text" name="last_name" value="<?php echo htmlentities($last_name); ?>" /></td>
  </tr>
  <tr>
    <th class="right highlight">Phone:</th>
	<td class="left">
	    <input class="phone" type="text" name="phone_country_code" maxlength="2" value="<?php echo htmlentities($phone_country_code); ?>" onkeypress="return numbers_only();"/>  
	  ( <input class="phone" type="text" name="phone_area_code" maxlength="3" value="<?php echo htmlentities($phone_area_code); ?>" onkeypress="return numbers_only();"/> )
	    <input class="phone" type="text" name="phone_prefix" maxlength="3" value="<?php echo htmlentities($phone_prefix); ?>" onkeypress="return numbers_only();"/> - 
	    <input class="phone" type="text" name="phone_line_number" maxlength="4" value="<?php echo htmlentities($phone_line_number); ?>" onkeypress="return numbers_only();"/>
	</td>
  </tr>
  <tr>
    <th class="right highlight">Street Number</th>
	<td class="left"><input type="text" name="street_number" value="<?php echo htmlentities($street_number); ?>" onkeypress="return numbers_only();"/></td>
  </tr>
  <tr>
	<th class="right highlight">Street Name</th>
	<td class="left"><input type="text" name="street" value="<?php echo htmlentities($street); ?>" /></td>
 </tr>
  <tr>
    <th class="right highlight">Unit:</th>
	<td class="left"><input type="text" name="unit" value="<?php echo htmlentities($unit); ?>" /></td>
  </tr>
  <tr>
    <th class="right highlight">City:</th>
	<td class="left"><input type="text" name="city" value="<?php echo htmlentities($city); ?>" /></td>
 </tr>
  <tr>
    <th class="right highlight">State:</th>
	<td class="left">
	  <select name="state">
	    <?php
		foreach($states as $abr){
			echo "<option ";
			if($abr == $state){
				echo "selected ";
			}
			echo "value=\"{$abr}\">{$abr}</option>";
		}
		?>
	  </select>
	</td>
 </tr>
  <tr>
    <th class="right highlight">Zip Code:</th>
	<td class="left"><input type="text" name="zipcode" value="<?php echo htmlentities($zipcode); ?>" onkeypress="return numbers_only();"/></td>
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
<!--
<form method="POST" action="<?php echo $action; ?>">
  <input class="test" type="submit" name="submit" value="Cancel" onclick="return confirm('Are you sure you want to cancel?')" />
</form>
-->
</div>


<?php include_once('../views/layouts/footer.php'); ?>	

<script>
function numbers_only(){
	return event.charCode >= 48 && event.charCode <= 57;
}
</script>