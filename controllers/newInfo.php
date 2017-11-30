<?php require_once('../controllers/initialize.php'); ?>
<?php
$infoArray = isset($_SESSION['infoArray']) ? $_SESSION['infoArray'] : [];
//Define form type
$formType = 'new';

//Define variables to posted values if set
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : (isset($infoArray['first_name']) ? $infoArray['first_name'] : '');
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : (isset($infoArray['last_name']) ? $infoArray['last_name'] : '');
$phone_country_code = isset($_POST['phone_country_code']) ? $_POST['phone_country_code'] : (isset($infoArray['phone']) ? substr($infoArray['phone'], 0, 2) : '');
$phone_area_code = isset($_POST['phone_area_code']) ? $_POST['phone_area_code'] : (isset($infoArray['phone']) ? substr($infoArray['phone'], 3, 3) : '');
$phone_prefix = isset($_POST['phone_prefix']) ? $_POST['phone_prefix'] : (isset($infoArray['phone']) ? substr($infoArray['phone'], 7, 3) : '');
$phone_line_number = isset($_POST['phone_line_number']) ? $_POST['phone_line_number'] : (isset($infoArray['phone']) ? substr($infoArray['phone'], 11, 4) : '');
$street_number = isset($_POST['street_number']) ? $_POST['street_number'] : (isset($infoArray['street_no']) ? $infoArray['street_no'] : '');
$street = isset($_POST['street']) ? $_POST['street'] : (isset($infoArray['street']) ? $infoArray['street'] : '');
$unit = isset($_POST['unit']) ? $_POST['unit'] : (isset($infoArray['unit']) ? $infoArray['unit'] : '');
$city = isset($_POST['city']) ? $_POST['city'] : (isset($infoArray['city']) ? $infoArray['city'] : '');
$state = isset($_POST['state']) ? $_POST['state'] : (isset($infoArray['state']) ? $infoArray['state'] : '');
$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : (isset($infoArray['zipcode']) ? $infoArray['zipcode'] : '');
$country = 'USA';

//If the Session email array is not set from the previous form, reroute
if(!isset($_SESSION['emailArray'])){
	header("Location:  ../views/index.php");
	exit;
}

//If the form as been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//Validate form - ensure all required fields are completed and that email does not already exist
	$user = new User();
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
		
		//Set session variable to array
		$_SESSION['infoArray'] = $user_array;
		
		//Route user to add new account page
		header("Location:  newAcct.php");
		exit;
		
	}
	
	
}else{
	$errors = "<br />";
}

?>

<?php include_once('../views/formInfo.php'); ?>	

