<?php include_once('../views/layouts/header.php'); ?>
<?php
if($formType == 'edit'){
	$submit = 'Submit';
	$action = '../views/info.php';
	$tableClass = 'formReview';
}elseif($formType == 'new'){
	$submit = 'Next';
	$action = '../controllers/logout.php';
	$tableClass = 'form';
}
?>
<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['emailArray'])){
?>
<div class="message1">Let's get started in setting up a new Bank of Earth Account.</div>
<div class="message2">First, let's set up an email and password.</div>
<?php 
} ?>

<?php
if($formType == 'new' && $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['emailArray'])){
?>
	<div class="fadeTimer center">
<?php 
}else{
?>
	<div class="center">
<?php 
}
?>
<h3 class="colorLight">Email Information</h3>
<?php
if($formType == 'edit'){
?>
<div class="instructions center">After changing your email and/or password, you will be logged out.</div>
<?php } ?>
<div class="instructions center">Passwords must be at least 8 characters long.</div>
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
    <th class="right highlight">Email:</th>
	<td><input type="text" name="email" value="<?php echo htmlentities($email); ?>" /></td>
	<td class="left"></td>
  </tr> 
  <tr>
    <th class="right highlight">Password:</th>
	<td><input type="password" name="password" /></td>
	<td class="left"></td>
  </tr>
  <tr>
    <th class="right highlight">Confirm Password:</th>
	<td><input type="password" name="confirm_password" /></td>
	<td></td>
  </tr>
</table>
<div>
	<input class="button" type="submit" name="submit" value="<?php echo $submit; ?>" />
	<a href="<?php echo $action; ?>" class="block buttonLink" onclick="return confirm('Are you sure you want to cancel?')">Cancel</a>
</form>
</div>


</div>
<?php include_once('../views/layouts/footer.php'); ?>	