<?php
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to add a new user(staff) to the system
// add_user.php?key=abcd&gid=2&did=1&uname=demo2&fname=emon&lname=umar&pswd=pass&ph=3264232&active=0
// the parameter active is optional, default is set to 1

// functions
function invalid(){
	echo "<node>";
		echo "<response>invalid</response>";
	echo "</node>";
	die(0);
}
function success(){
	echo "<node>";
		echo "<response>success</response>";
	echo "</node>";
	die(0);
}
function failed(){
	echo "<node>";
		echo "<response>failed</response>";
	echo "</node>";
	die(0);
}

date_default_timezone_set('Asia/Calcutta');
$created_on		= date("Y-n-j").' '.date("H:i:s");

// include config file, also contains the API KEY
require_once('../config.php');

// get the request details
$api_key		= strip_tags($_REQUEST['key']);
$group_id		= strip_tags($_REQUEST['gid']);
$dept_id		= strip_tags($_REQUEST['did']);
$username		= strip_tags($_REQUEST['uname']);
$firstname		= strip_tags($_REQUEST['fname']);
$lastname		= strip_tags($_REQUEST['lname']);
$password		= strip_tags($_REQUEST['pswd']);
$phone			= strip_tags($_REQUEST['ph']);
$is_active		= strip_tags($_REQUEST['active']);


// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	// check for empty
	if($api_key == '' || $group_id == '' || $dept_id == '' || $username == '' || $password == '' || $firstname == '' || $lastname == '' || $phone == ''){
		invalid();
	}else{
		// process the request
		if($is_active==''){
			// account active by default
			$is_active = '1';
		}
		require_once('dbcon.php');
		$password = md5($password);
		$query = "INSERT INTO isost_staff(
			group_id, dept_id, username, firstname, lastname, passwd, phone, isactive, created)
			VALUES('$group_id', '$dept_id', '$username', '$firstname', '$lastname', '$password', '$phone', '$is_active', '$created_on')";

		$result = mysql_query($query);
		
		$done = mysql_affected_rows();
		if($done=='1'){
			success();
		}else{
			failed();
		}
	}
}
?>