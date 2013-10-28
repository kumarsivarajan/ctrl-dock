<?
include("config.php"); 
if (!check_feature(37)){feature_error();exit;}

$system_id=$_REQUEST["id"];
$asset_db            =$DATABASE_NAME."_oa";

mysql_select_db($asset_db, $link);
$sub_sql="delete from sys_sw_software_key where system_id='$system_id'";
$sub_result = mysql_query($sub_sql);

$sub_sql="delete from system where system_id='$system_id'";
$sub_result = mysql_query($sub_sql);	
	
?>
<meta http-equiv="refresh" content="0;url=../OA2/index.php/main/list_devices/1">