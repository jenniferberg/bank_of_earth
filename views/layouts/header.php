<?php include_once('../controllers/initialize.php'); ?>
<html>
  <head>
    <title>
	  <?php echo $title; ?>
	</title>
	<link rel="stylesheet" href="../stylesheets/styles.css" type="text/css" />
    <script src="../scripts/jquery.js"></script>
  </head>
  <body>
  
  
<?php if(isset($userEmail) && !empty($userEmail) && $page != 'wait') { ?>
 
	<div class="navigation">
	  <a href="../views/index.php" class="nav">Accounts</a>
	  <a href="../views/info.php" class="nav">Personal Information</a>
	  <a href="../controllers/atm.php" class="nav">ATM</a>
	  <a href="../controllers/logout.php" class="nav" onclick="return confirm('Are you sure you want to log out?')">Log Out</a>
	</div>
	<div class="title"><?php echo "Welcome to ".$title;?></div>
	<div class="body">
	  <div class="center greetings">Greetings, <?php echo $userName; ?>!</div>
     <div class="page fadeIn">
	  
<?php } 
else { ?>
	<div class="body">
<?php }
?>