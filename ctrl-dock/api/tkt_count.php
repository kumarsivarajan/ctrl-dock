<?php
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to count the number of tickets, open, close, total
// ticket_count.php?key=abcd&type=open
// by default it returns the total number of tickets unless a specific type is mentioned

function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

// include config file, also contains the API KEY
require_once('../config.php');
require_once('dbcon.php');

$api_key		= strip_tags($_REQUEST['key']);
$type			= strip_tags($_REQUEST['type']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	// check for status
	if($type==''){
		$result = mysql_query("SELECT * FROM isost_ticket");
		$num_rows = mysql_num_rows($result);
		success($num_rows);
	}
	else if($type=='open'){
		$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open'");
		$num_rows = mysql_num_rows($result);
		success($num_rows);
	}
	else if($type=='closed'){
		$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'closed'");
		$num_rows = mysql_num_rows($result);
		success($num_rows);
	}
}
?>