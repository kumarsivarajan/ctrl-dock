<?php
include_once("auth.php");

// if the user is logged in, unset the session

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
   unset($_SESSION['username']);
   unset($_SESSION['password']);
}
?>
<meta http-equiv="refresh" content="0; url=index.php">