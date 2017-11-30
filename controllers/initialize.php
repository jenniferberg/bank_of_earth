<?php
//Directory separator
const DS = DIRECTORY_SEPARATOR;

//Site Root
//Complete the '...' with your own file path
const SITE_ROOT = '...'.DS.'bank_of_earth';

//Classes Root
const CLASS_ROOT = 'models'.DS.'classes';

//Functions Root
const FUNCT_ROOT = 'models'.DS.'functions';

//Required functions
require_once(SITE_ROOT.DS.FUNCT_ROOT.DS.'validation_functions.php');
require_once(SITE_ROOT.DS.FUNCT_ROOT.DS.'functions.php');

//Required classes
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'session.php');
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'database.php');
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'database_queries.php');
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'user.php');
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'bank_account.php');
require_once(SITE_ROOT.DS.CLASS_ROOT.DS.'account_transaction.php');
?>

<?php
$title = "Bank of Earth";
$page = '';

//Get current datetime
$now = new DateTime();
$date = $now->format('Y-m-d H:i:s');


$userEmail = isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : '';
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';


if(isset($userEmail) && !empty($userEmail)){
	$user = new User();
	$person = $user->get_user_by_email($userEmail);
	$person = $person[0];
	
	//Apply interest before user logs in
	require_once('../controllers/interest.php');
	
}
?>