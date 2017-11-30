<?php
require_once('../controllers/initialize.php');

$session->end_session();

header("Location:  login.php");
exit;

?>