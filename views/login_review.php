<?php include_once('../controllers/initialize.php'); ?>
<?php $page = 'wait'; ?>
<?php 
if(!isset($userEmail) || empty($userEmail)){
	header("Location:  ../controllers/login.php");
	exit;
}
?>
<?php include_once('../views/layouts/header.php'); ?>

<div class="message1">Greetings, <?php echo $userName; ?>!<br /> Welcome to Bank of Earth.</div>
<div class="message2">Wait one moment<br />while we log you in...</div>
<div class="fadeTimer">
<?php include_once('../views/layouts/navigation.php'); ?>
</div>
<?php include_once('../views/layouts/footer.php');?>	
<?php

//Route the user to the main page
header("Refresh: 13; url=index.php");
exit;
	
?>
