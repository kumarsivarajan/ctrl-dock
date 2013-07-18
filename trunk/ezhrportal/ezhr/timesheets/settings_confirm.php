<?php 
include_once("config.php");

$min_hrs					=$_REQUEST["min_hrs"];
$business_group_index		=$_REQUEST["index"];

$sql="update timesheet_minhrs set min_hrs='$min_hrs' where business_group_index='$business_group_index'";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=settings.php">