<?php
include("auth.php"); 

//Reset terminal login status

$sql="delete from terminal_login where username='".$_SESSION['username']."'";
$result = mysql_query($sql);
	
	
// if the user is logged in, unset the session

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
   unset($_SESSION['username']);
   unset($_SESSION['password']);
}

$loc = "Location: "."index.php";	
header($loc);
?>