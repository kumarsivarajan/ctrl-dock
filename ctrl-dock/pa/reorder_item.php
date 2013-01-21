<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$activity_id			=$_REQUEST["activity_id"];

$table					=$_REQUEST["table"];
$record_index			=$_REQUEST["record_index"];
$action					=$_REQUEST["action"];

$prev_record			=$_REQUEST["prev_record"];
$next_record			=$_REQUEST["next_record"];


$sql="select item_order from $table where record_index='$record_index'";
$result = mysql_query($sql);
$row= mysql_fetch_row($result);
$curr_order=$row[0];

$sql="select item_order from $table where record_index='$prev_record'";
$result = mysql_query($sql);
$row= mysql_fetch_row($result);
$prev_order=$row[0];

$sql="select item_order from $table where record_index='$next_record'";
$result = mysql_query($sql);
$row= mysql_fetch_row($result);
$next_order=$row[0];


if($action=="up"){
	$sql="update $table set item_order='$curr_order' where record_index='$prev_record'";
	$result = mysql_query($sql);	
	$sql="update $table set item_order='$prev_order' where record_index='$record_index'";
	$result = mysql_query($sql);
}

if($action=="down"){
	$sql="update $table set item_order='$curr_order' where record_index='$next_record'";	
	$result = mysql_query($sql);
	$sql="update $table set item_order='$next_order' where record_index='$record_index'";	
	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=pa_edit_1.php?activity_id=<?echo $activity_id;?>">