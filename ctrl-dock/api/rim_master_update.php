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
$exception		= strip_tags($_REQUEST['exception']);
$emergency		= strip_tags($_REQUEST['emergency']);
$high			= strip_tags($_REQUEST['high']);
$normal			= strip_tags($_REQUEST['normal']);
$low			= strip_tags($_REQUEST['low']);
$unassigned		= strip_tags($_REQUEST['unassigned']);
$hosts_nw_status	= strip_tags($_REQUEST['hosts_nw_status']);
$hosts_svc_status	= strip_tags($_REQUEST['hosts_svc_status']);
$hosts_perf_status	= strip_tags($_REQUEST['hosts_perf_status']);
$timestamp		=	mktime();


// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "delete from rim_master where agency_index='$agency_index'";
		$result = mysql_query($sql);	
		
		$sql = "insert into rim_master (agency_index,exception,emergency,high,normal,low,unassigned,hosts_nw_status,hosts_svc_status,hosts_perf_status,timestamp) values ($agency_index,$exception,$emergency,$high,$normal,$low,$unassigned,$hosts_nw_status,$hosts_svc_status,$hosts_perf_status,$timestamp)";
		$result = mysql_query($sql);	
}
?>
