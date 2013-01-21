<?
include_once("include/config.php");
include_once("include/db.php");

$sql="select terminalport from config";
$result=mysql_query($sql);
$row = mysql_fetch_row($result);
echo $row[0];
?>
