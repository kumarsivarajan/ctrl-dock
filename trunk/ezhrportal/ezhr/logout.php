<?php
	$check_service = "RIM_CLIENT";
	include("auth.php"); 


// if the user is logged in, unset the session

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
   unset($_SESSION['username']);
   unset($_SESSION['password']);
}

$loc = "Location: "."index.php";		
header($loc);
?>