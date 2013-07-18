<?php 
include_once("config.php");

$account		=$_REQUEST["account"];

$sql="delete from timesheet_exception where username='$account'";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=exceptions.php">