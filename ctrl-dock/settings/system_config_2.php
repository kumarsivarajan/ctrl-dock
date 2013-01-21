<?php 
include("config.php");
if (!check_feature(41)){feature_error();exit;} 

$account_as_email	=$_REQUEST["account_as_email"];
$md5_enable			=$_REQUEST["md5_enable"];
$asset_prefix		=$_REQUEST["asset_prefix"];
$audit_expiry		=$_REQUEST["audit_expiry"];

$ezrim				=$_REQUEST["ezrim"];
$master_url			=$_REQUEST["master_url"];
$master_api_key		=$_REQUEST["master_api_key"];
$agency_id			=$_REQUEST["agency_id"];
$https				=$_REQUEST["https"];

$service_dash		=$_REQUEST["service_dash"];
$service_ezasset	=$_REQUEST["service_ezasset"];
$service_ezticket	=$_REQUEST["service_ezticket"];
$service_network	=$_REQUEST["service_network"];
$snmp				=$_REQUEST["snmp"];
$terminal			=$_REQUEST["terminal"];
$terminalport       =$_REQUEST["terminalport"];


$sql = "update config set account_as_email='$account_as_email', md5_enable='$md5_enable',asset_prefix='$asset_prefix', audit_expiry='$audit_expiry',https='$https',";
$sql.= " ezrim='$ezrim',master_url='$master_url',master_api_key='$master_api_key',agency_id='$agency_id',";
$sql.= " service_dash='$service_dash', service_ezasset='$service_ezasset', service_ezticket='$service_ezticket', service_network='$service_network', snmp='$snmp', terminal='$terminal', terminalport='$terminalport'";

$result=mysql_query($sql);	
?>
<i><b><font size=2 color="#003366" face="Arial">The configuration was updated successfully.</font></b></i>