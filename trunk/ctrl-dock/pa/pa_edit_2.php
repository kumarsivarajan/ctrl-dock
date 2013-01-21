<?php 
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$activity_id	=$_REQUEST["activity_id"];
$project		=$_REQUEST["project"];

$location		=clean_string($_REQUEST["location"]);

$action					="ADDED";
$action_by				=$username;
$action_date			=mktime();


$sql="select * from poa_information where activity_id='$activity_id' order by record_index DESC limit 1";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	$action="EDITED";
}

$activity_description	=clean_string($_REQUEST["activity_description"]);
$activity_impact		=clean_string($_REQUEST["activity_impact"]);
$activity_services		=clean_string($_REQUEST["activity_services"]);
$activity_verification	=clean_string($_REQUEST["activity_verification"]);
$release_notes			=clean_string($_REQUEST["release_notes"]);

$calendar_date		=$_REQUEST["s_from_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$s_from				=mktime($_REQUEST["s_from_time_hh"],$_REQUEST["s_from_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["s_to_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$s_to				=mktime($_REQUEST["s_to_time_hh"],$_REQUEST["s_to_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["a_from_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$a_from				=mktime($_REQUEST["a_from_time_hh"],$_REQUEST["a_from_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["a_to_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$a_to				=mktime($_REQUEST["a_to_time_hh"],$_REQUEST["a_to_time_mm"],0,$month,$day,$year);


$sql="insert into poa_information(activity_id,scheduled_start_date,scheduled_end_date,actual_start_date,actual_end_date,location,action,action_by,action_date,activity_description,activity_impact,activity_services,activity_verification,release_notes) values ('$activity_id','$s_from','$s_to','$a_from','$a_to','$location','$action','$action_by','$action_date','$activity_description','$activity_impact','$activity_services','$activity_verification','$release_notes')";
$result = mysql_query($sql);

$sql="update poa_master set project='$project' where activity_id='$activity_id'";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=index.php">
