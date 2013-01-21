<?php

// This API is used to update the RIM_MASTER table


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
$ticket_id		= strip_tags($_REQUEST['ticket_id']);
$ticket_date	= strip_tags($_REQUEST['ticket_date']);
$ticket_summary	= strip_tags($_REQUEST['ticket_summary']);
$ticket_type		= strip_tags($_REQUEST['ticket_type']);
$ticket_priority	= strip_tags($_REQUEST['ticket_priority']);
$assigned_to		= strip_tags($_REQUEST['assigned_to']);
$escalation_level	= strip_tags($_REQUEST['escalation_level']);


$timestamp		=	mktime();


// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	
		$sql = "insert into rim_master_escalation_log  (agency_index,ticket_id,ticket_date,ticket_summary,ticket_type,ticket_priority,assigned_to,escalation_level,escalation_date)";
		$sql.=" values ('$agency_index','$ticket_id','$ticket_date','$ticket_summary','$ticket_type','$ticket_priority','$assigned_to','$escalation_level','$timestamp')";
		$result = mysql_query($sql);	
}
?>
