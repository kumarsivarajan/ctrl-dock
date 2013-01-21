<?php 
include_once("config.php");
if (!check_feature(47)){feature_error();exit;}


$activity_id			=$_REQUEST["activity_id"];
$approver				=explode("||",$_REQUEST["approver"]);
$approver_name			=$approver[0];
$approver_email			=$approver[1];


$action					="ADDED";
$action_by				=$username;
$action_date			=mktime();

$approver_key="";

if(strlen($approver_email)>0){
	$lower=$level*1000;
	$upper=$next_level*1000;
	
	$sql="select count(*) from rca_approval_history where activity_id='$activity_id' and item_order>=$lower and item_order<$upper";

	$result = mysql_query($sql);
	$row= mysql_fetch_row($result);
	$row_count=$row[0];
	$item_order=$lower+$row_count;
		
	$sql="insert into rca_approval_history (activity_id,action,action_by,action_date,item_order,approver_name,approver_email,approver_key) values ('$activity_id','$action','$action_by','$action_date','$item_order','$approver_name','$approver_email','$approver_key')";

	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=rca_edit_1.php?activity_id=<?=$activity_id;?>">