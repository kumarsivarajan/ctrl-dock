<?php 
include_once("config.php");

$account		=$_REQUEST["account"];

$sql="insert into timesheet_exception values ('$account')";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=exceptions.php">