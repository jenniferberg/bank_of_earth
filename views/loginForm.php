<?php include_once('../views/layouts/header.php'); ?>

<?php if($_SERVER['REQUEST_METHOD'] == 'GET'){ ?> <div class="titleLogin titleFadeIn"> <?php }else{ ?> <div class="titleLogin"> <?php } ?>
<?php echo "Welcome to ".$title;?></div>
<?php if(isset($errors) && $errors != "<br />"){ ?> 
<div class="error">
  <?php echo $errors; ?>
</div>
<?php } ?>

<?php if($_SERVER['REQUEST_METHOD'] == 'GET'){ ?> <div class="logIn logInFade"> <?php }else{ ?> <div class="logIn"> <?php } ?>
<div id="loginText">
 Please Log In
</div>
<form method="POST">
<table class="loginForm">
  <tr>
    <th class="right">Email:</th>
	<td><input type="text" name="email" value="<?php echo htmlentities($email); ?>" /></td>
	<td><?php echo isset($validate['email']) ? $validate['email'] : ''; ?></td>
  </tr> 
  <tr>
    <th class="right">Password:</th>
	<td><input type="password" name="password" /></td>
	<td><?php echo isset($validate['password']) ? $validate['password'] : ''; ?></td>
  </tr>
  <tr>
    <td colspan="3">
	  <input class="button" type="submit" name="submit" value="Submit" />
	</td>
</table>
</form> 
</div>
<?php if($_SERVER['REQUEST_METHOD'] == 'GET'){ ?> <div class="newProfile newProfileFade"> <?php }else{ ?> <div class="newProfile"> <?php } ?>
  Click <a href="newEmail.php">here</a> to create a new profile and bank account.
</div>
  

<?php include_once('../views/layouts/footer.php'); ?>	