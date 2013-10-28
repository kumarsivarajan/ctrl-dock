<?
include_once("../include/config.php");
include_once("../include/db.php");
$asset_db=$DATABASE_NAME."_oa";

mysql_select_db($asset_db, $link);

$sql = "SELECT distinct system_id from sys_sw_software_key order by system_id";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
	$system_id=$row[0];
	
	$sub_sql="select max(UNIX_TIMESTAMP(timestamp)) from sys_sw_software_key where system_id='$system_id'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$last_timestamp=$sub_row[0];
	
	$sub_sql="delete from sys_sw_software_key where system_id='$system_id' and UNIX_TIMESTAMP(timestamp)<$last_timestamp";
	$sub_result = mysql_query($sub_sql);
}
?>