<?php

// This API is used to update the ticket count per staff on the RIM Master


function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}


// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$agency_index	= strip_tags($_REQUEST['agency']);
$assigned_to	= strip_tags($_REQUEST['assigned_to']);
$ticket_count	= strip_tags($_REQUEST['ticket_count']);

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	$sql ="select * from rim_master_mytickets where agency_index='$agency_index' and assigned_to='$assigned_to'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)>0){
		$sql="update rim_master_mytickets set ticket_count='$ticket_count' where agency_index='$agency_index' and assigned_to='$assigned_to'";
	}else{
		$sql="insert into rim_master_mytickets values ('$agency_index','$assigned_to','$ticket_count')";
	}
	$result = mysql_query($sql);
}
?>
