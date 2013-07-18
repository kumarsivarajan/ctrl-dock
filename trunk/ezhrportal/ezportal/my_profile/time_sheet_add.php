<?php 
include("config.php");

$now=mktime();

$agency_index		=$_REQUEST["agency_index"];
$context_id			=$_REQUEST["context_id"];

$calendar_date		=$_REQUEST["s_from_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$s_from				=mktime($_REQUEST["s_from_time_hh"],$_REQUEST["s_from_time_mm"],0,$month,$day,$year);

$calendar_date		=$_REQUEST["s_to_date"];
$day=substr($calendar_date,0,2);$month=substr($calendar_date,3,2);$year=substr($calendar_date,6,4);
$s_to				=mktime($_REQUEST["s_to_time_hh"],$_REQUEST["s_to_time_mm"],0,$month,$day,$year);

$activity_details=$_REQUEST["activity_details"];
$activity_details=str_replace("'","",$activity_details);

$error=0;
if($_REQUEST["s_from_date"]<=0 ||  $_REQUEST["s_to_date"]<=0){
	$error=1;
	$error_msg="Mandatory fields were left blank.";
}

if($s_from > $now || $s_to > $now){
	$error=1;
	$error_msg="The date & time mentioned cannot be in the future.";
}

if($s_from > $s_to){
	$error=1;
	$error_msg="The start date and time cannot be greater than the end date and time.";
}

if($error==1){
	?>
	<center>
	<font face="Arial" size="2" color="#003399"><b>
	<?=$error_msg;?>
	<br><br>
	<a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a>
	<?
}

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
        $sql = "insert into timesheet (agency_index,context_id,start_date,end_date,activity,username)";
		$sql.=" values ('$agency_index','$context_id','$s_from','$s_to','$activity_details','$employee')";
        $result = mysql_query($sql);
?>
	<p align="center"><b><font color="#003366" face="Arial" size=2>The timesheet was updated.<br><br>Please wait while you are returned to the previous screen.</font></b></p>
	<meta http-equiv="REFRESH" content="0;URL=time_sheet.php">
  <?php
}
?>
