<?
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API when called returns a value of 1 or 0 which indicates whether the user has logged in or not
// Useful to integrate 3rd party applications
// dock_auth.php

ini_set('session.gc_maxlifetime', 28800);    
session_name('RIM_ADMIN');
session_start();

include("../include/config.php");	
include("../include/db.php");

	
$valid_till="";
	

if(isset($username)&&isset($password)){
	$_SESSION['username']=$username;
	$_SESSION['password']=$password;
}

if ($MD5_ENABLE==1){
	$check_pass=md5($_SESSION['password']);
}else{
	$check_pass=$_SESSION['password'];
}
	
$sql = sprintf("SELECT first_name,last_name,account_expiry 
       		FROM user_master a 
			WHERE a.username='%s' AND a.password='%s' 
			AND a.account_status='Active'",mysql_real_escape_string($_SESSION['username']),mysql_real_escape_string($check_pass));
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$record_count=mysql_num_rows($result);
			
$valid_till=$row[2];
$current=mktime(0,0,0);
if ($valid_till==""){$valid_till=$current+86400;}
$status=0;
if($record_count>0 && $valid_till>=$current){		  					            	
    $User_Full_Name=$row[0] . " " . $row[1];
    $username=$_SESSION['username'];
	$status=1;
}
echo "<node>";
echo "<login>";
echo "<status>$status</status>";
echo "</login>";
echo "</node>";
?>
