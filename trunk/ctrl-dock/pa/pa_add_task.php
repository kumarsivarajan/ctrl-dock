<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$activity_id			=clean_string($_REQUEST["activity_id"]);
$table					=$_REQUEST["table"];
$task_description		=clean_string($_REQUEST["task_description"]);
$task_duration			=clean_string($_REQUEST["task_duration"]);
$task_owner				=clean_string($_REQUEST["task_owner"]);

$action					="ADDED";
$action_by				=$username;
$action_date			=mktime();

if(strlen($task_description)>0){
	$sql="select count(*) from $table where activity_id='$activity_id'";
	$result = mysql_query($sql);
	$row= mysql_fetch_row($result);
	$item_order=$row[0]+1;

	$sql="insert into $table (activity_id,task_description,task_duration,task_owner,action,action_by,action_date,item_order) values ('$activity_id','$task_description','$task_duration','$task_owner','$action','$action_by','$action_date','$item_order')";

	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=pa_edit_1.php?activity_id=<?=$activity_id;?>">