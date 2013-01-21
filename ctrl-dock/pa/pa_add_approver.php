<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$activity_id			=clean_string($_REQUEST["activity_id"]);
$approver				=explode("||",$_REQUEST["approver"]);
$approver_name			=$approver[0];
$approver_email			=$approver[1];



$action					="ADDED";
$action_by				=$username;
$action_date			=mktime();

$approver_key="";

if(strlen($approver_email)>0){
	$sql="select count(*) from poa_approval_history where activity_id='$activity_id'";
	$result = mysql_query($sql);
	$row= mysql_fetch_row($result);
	$item_order=$row[0]+1;
	
	$sql="insert into poa_approval_history (activity_id,action,action_by,action_date,item_order,approver_name,approver_email,approver_key) values ('$activity_id','$action','$action_by','$action_date','$item_order','$approver_name','$approver_email','$approver_key')";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=pa_edit_1.php?activity_id=<?=$activity_id;?>">