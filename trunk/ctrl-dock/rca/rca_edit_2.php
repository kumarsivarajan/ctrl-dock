<?php 
include_once("config.php");
if (!check_feature(48)){feature_error();exit;}

$activity_id	=$_REQUEST["activity_id"];
$project		=trim($_REQUEST["project"]);

$action					="ADDED";
$action_by				=$username;
$action_date			=mktime();


$sql="select * from rca_information where activity_id='$activity_id' order by record_index DESC limit 1";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	$action="EDITED";
}


$description			=clean_string($_REQUEST["description"]);
$symptoms				=clean_string($_REQUEST["symptoms"]);
$impact_analysis		=clean_string($_REQUEST["impact_analysis"]);

$ca_root_cause			=clean_string($_REQUEST["ca_root_cause"]);
$ca_reason				=clean_string($_REQUEST["ca_reason"]);
$ca_action				=clean_string($_REQUEST["ca_action"]);

$pa_action				=clean_string($_REQUEST["pa_action"]);
$recommendations			=clean_string($_REQUEST["recommendations"]);
$observations			=clean_string($_REQUEST["observations"]);


$calendar_date		=$_REQUEST["open_date"];
$day				=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$open_date			=mktime($_REQUEST["open_time_hh"],$_REQUEST["open_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["attended_date"];
$day				=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$attended_date		=mktime($_REQUEST["attended_time_hh"],$_REQUEST["attended_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["closure_date"];
$day				=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$closure_date		=mktime($_REQUEST["closure_time_hh"],$_REQUEST["closure_time_mm"],0,$month,$day,$year);



$sql="insert into rca_information(activity_id,open_date,attended_date,closure_date,description,symptoms,impact_analysis,ca_root_cause,ca_reason,ca_action,pa_action,recommendations,observations) values ('$activity_id','$open_date','$attended_date','$closure_date','$description','$symptoms','$impact_analysis','$ca_root_cause','$ca_reason','$ca_action','$pa_action','$recommendations','$observations')";
$result = mysql_query($sql);

$sql="update rca_master set project='$project',action_by='$action_by',action_date='$action_date' where activity_id='$activity_id'";
$result = mysql_query($sql);

?>
<meta http-equiv="REFRESH" content="0;URL=index.php">
