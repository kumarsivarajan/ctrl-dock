<?php 
include_once("config.php");

$record_index			=$_REQUEST["record_index"];

$ui_from_date			=$_REQUEST["ui_from_date"];
$ui_to_date				=$_REQUEST["ui_to_date"];

$account				=$_REQUEST["account"];
$comments				=$_REQUEST["comments"];

$sql="select * from timesheet where record_index='$record_index'";
$result = mysql_query($sql);
$row=mysql_fetch_row($result);

$record_index	=$row[0];
$agency_index	=$row[1];
$context_id		=$row[2];
$del_user		=$row[3];
$start_date		=$row[4];
$end_date		=$row[5];
$activity		=$row[6];
$deleted_on		=mktime();
$deleted_by		=$username;

$sql="insert into timesheet_delete values ('$record_index','$agency_index','$context_id','$del_user','$start_date','$end_date','$activity','$deleted_on','$deleted_by','$comments')";
$result = mysql_query($sql);

$sql="delete from timesheet where record_index='$record_index'";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=index.php?account=<?=$account;?>&from_date=<?=$ui_from_date;?>&to_date=<?=$ui_to_date;?>">