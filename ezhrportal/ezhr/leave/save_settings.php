<?php 

include_once("config.php");
include_once("header.php");

$lcs	=$_REQUEST["lcs"];
$clv	=$_REQUEST["clv"];
$lct	=$_REQUEST["lct"];


$sql = "update config_ezportal set leave_calendar_start='$lcs', compensatory_leave_validity='$clv',lc_threshold='$lct'";
$result = mysql_query($sql);
?>		
<font face=Arial size=2 color=blue><b><i> The settings have been updated.</i></b>
<meta http-equiv="refresh" content="1;url=index.php">