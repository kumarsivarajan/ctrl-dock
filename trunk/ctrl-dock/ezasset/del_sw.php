<?
include_once("config.php");

$asset_db            =$DATABASE_NAME."_oa";

$package_id=$_REQUEST["id"];

mysql_select_db($asset_db, $link);
$sql = "delete from sw_licenses where package_id='$package_id'"; 	
$result = mysql_query($sql);

?>
<meta http-equiv="Refresh" content="0; URL=add_sw_1.php">