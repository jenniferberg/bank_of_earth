<?php require_once('../controllers/initialize.php'); ?>

<?php
//Define form type
$formType = 'edit';

//Define variables to posted values if set, otherwise values in database
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : $person['first_name'];
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : $person['last_name'];
$phone_country_code = isset($_POST['phone_country_code']) ? $_POST['phone_country_code'] : substr($person['phone'], 0, 2);
$phone_area_code = isset($_POST['phone_area_code']) ? $_POST['phone_area_code'] : substr($person['phone'], 3, 3);
$phone_prefix = isset($_POST['phone_prefix']) ? $_POST['phone_prefix'] : substr($person['phone'], 7, 3);
$phone_line_number = isset($_POST['phone_line_number']) ? $_POST['phone_line_number'] : substr($person['phone'], 11, 4);
$street_number = isset($_POST['street_number']) ? $_POST['street_number'] : $person['street_no'];
$street = isset($_POST['street']) ? $_POST['street'] : $person['street'];
$unit = isset($_POST['unit']) ? $_POST['unit'] : $person['unit'];
$city = isset($_POST['city']) ? $_POST['city'] : $person['city'];
$state = isset($_POST['state']) ? $_POST['state'] : $person['state'];
$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : $person['zipcode'];
$country = 'USA';

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Validate form
	$validate = $user->validate_user_info();
	
	if($validate){
		$errors = "Please fix the below errors";
	}else{
		//Concatenate phone segments into a single variable
		$phone = $phone_country_code."-".$phone_area_code."-".$phone_prefix."-".$phone_line_number;
		
		//Create array of values
		$user_array = ['first_name' => $first_name, 'last_name' => $last_name, 
					   'phone' => $phone, 'street_no' => $street_number,
					   'street' => $street, 'unit' => $unit, 'city' => $city, 
					   'state' => $state, 'country' => $country, 'zipcode' => $zipcode];
		
		//Update user information in the database
		$user->update($user_array, $person['id']);
		
		//Route user back to personal information page
		header("Location:  ../views/info.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formInfo.php'); ?>	