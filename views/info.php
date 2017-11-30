<?php require_once('../controllers/initialize.php'); ?>

<?php
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  ../controllers/login.php");
	exit;
}
?>


<?php include_once('../views/layouts/header.php'); ?>

<table class="formReview">
  <tr>
    <th class="right">Name:</th>
	<td class="left"><?php echo $userName; ?></td>
  </tr>
  <tr>
	<th class="right">Phone:</th>
	<td class="left"><?php echo $person['phone']; ?></td>
  </tr>
  <tr>
	<th class="right">Email:</th>
	<td class="left"><?php echo $person['email']; ?></td>
  </tr>
  <tr>
	<th class="right">Address:</th>
	<td class="left"><?php echo $person['street_no']." ".$person['street']; ?></td>
  </tr>
  <?php if(isset($person['unit'])){
	  echo 
		  "<tr>
			<th class=\"right\">Unit:</th>
			<td class=\"left\">".$person['unit']."</td>
		  </tr>"; 
		}
  ?>
  <tr>
	<th class="right">City:</th>
	<td class="left"><?php echo $person['city']; ?></td>
  </tr>
  <tr>
	<th class="right">State:</th>
	<td class="left"><?php echo $person['state']; ?></td>
  </tr>
  <tr>
	<th class="right">Zip Code:</th>
	<td class="left"><?php echo $person['zipcode']; ?></td>
  </tr>
  <tr>
	<th class="right">Country:</th>
	<td class="left"><?php echo $person['country']; ?></td>
  </tr>
</table>
<div class="center">

  <a href="../controllers/editInfo.php" class="block buttonLinkWide">Edit Personal Information</a>

</div>
<div class="center">
<a href="../controllers/editEmail.php" class="block buttonLinkWide">Change Email and Password</a>
</div>

<?php include_once('../views/layouts/footer.php'); ?>	