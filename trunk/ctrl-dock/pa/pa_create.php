<?php 
include_once("config.php");
if (!check_feature(49)){feature_error();exit;}

$project		=trim($_REQUEST["project"]);

$action			="DRAFT";
$action_by		=$username;
$action_date	=mktime();


if(strlen($project)>0){
	$sql="insert into poa_master(project,action,action_by,action_date)values ('$project','$action','$action_by','$action_date')";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="REFRESH" content="0;URL=index.php">
