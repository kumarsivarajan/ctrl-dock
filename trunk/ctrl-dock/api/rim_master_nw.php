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
$hostname		= strip_tags($_REQUEST['hostname']);
$description	= strip_tags($_REQUEST['description']);
$platform		= strip_tags($_REQUEST['platform']);
$network		= strip_tags($_REQUEST['network']);
$live			= strip_tags($_REQUEST['live']);
$count			= strip_tags($_REQUEST['count']);
$snmp			= strip_tags($_REQUEST['snmp']);
$network_snmp_cpu_status	= strip_tags($_REQUEST['network_snmp_cpu_status']);
$cpu						= strip_tags($_REQUEST['cpu']);
$network_snmp_mem_status	= strip_tags($_REQUEST['network_snmp_mem_status']);
$mem						= strip_tags($_REQUEST['mem']);
$network_snmp_dsk_status	= strip_tags($_REQUEST['network_snmp_dsk_status']);
$dsk						= strip_tags($_REQUEST['dsk']);

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	$sql ="delete from rim_master_nw where agency_index='$agency_index' and hostname='$hostname'";
	$result = mysql_query($sql);
	
	$sql="insert into rim_master_nw values ('$agency_index','$hostname','$description','$platform','$network','$live','$count','$snmp','$network_snmp_cpu_status','$cpu','$network_snmp_mem_status','$mem','$network_snmp_dsk_status','$dsk')";
	$result = mysql_query($sql);
}
?>
