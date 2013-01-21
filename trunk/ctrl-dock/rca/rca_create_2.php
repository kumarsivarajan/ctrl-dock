<?php 
include_once("config.php");
if (!check_feature(47)){feature_error();exit;}

$ticket_id=$_REQUEST["ticket_id"];
$project		=trim($_REQUEST["project"]);

$action			="DRAFT";
$action_by		=$username;
$action_date	=mktime();


if(strlen($project)>0){
	$sql="insert into rca_master(activity_id,project,action,action_by,action_date)values ('$ticket_id','$project','$action','$action_by','$action_date')";
	$result = mysql_query($sql);
?>
<h3>An RCA has been attached with this ticket with an ID <?=$ticket_id;?>
<input type="button" value="Close" onclick="window.close()" class=forminputbutton>
<?}?>