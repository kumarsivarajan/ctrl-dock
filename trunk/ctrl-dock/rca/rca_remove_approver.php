<?php 
include_once("config.php");
if (!check_feature(47)){feature_error();exit;}

$activity_id			=clean_string($_REQUEST["activity_id"]);
$record_index			=clean_string($_REQUEST["record_index"]);

$action					="DELETED";
$action_by				=$username;
$action_date			=mktime();

if(strlen($record_index)>0){
	$sql="delete from rca_approval_history where record_index='$record_index' order by record_index";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=rca_edit_1.php?activity_id=<?echo $activity_id;?>">