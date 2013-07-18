<?php 
include("config.php");
include("../common/functions/date.php"); 

$employee=$_SERVER["PHP_AUTH_USER"];

echo "<center><table border=0 width=50%>";

$timesheet_date=$_REQUEST["timesheet_date"];if (strlen($timesheet_date)<= 0){$error=1;}
$timesheet_date=date_to_int($timesheet_date);
$agency_index=$_REQUEST["agency_index"];

if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The date was left blank </font></b></td></tr>";
}

$hours=$_REQUEST["hours"];if (strlen($hours)<= 0){$error=2;}
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The no. of hours was left blank </font></b></td></tr>";
}

$project_code=$_REQUEST["project_code"];if (strlen($project_code)<=0){$error=3;}
if ($error==3){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The project / activity was left blank </font></b></td></tr>";
}

$activity_details=$_REQUEST["activity_details"];if (strlen($activity_details)<=0){$error=4;}
$activity_details=str_replace("'","",$activity_details);

if ($error==4){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The project / activity details were left blank </font></b></td></tr>";
}

  
if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
}

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
        $sql = "insert into timesheet (username,project_code,date,hours,task,agency_index) values ('$employee','$project_code','$timesheet_date','$hours','$activity_details','$agency_index')";
        $result = mysql_query($sql);	
?>
	<p align="center"><b><font color="#003366" face="Arial" size=2>The timesheet was updated.<br><br>Please wait while you are returned to the previous screen.</font></b></p>
	<meta http-equiv="REFRESH" content="2;URL=user_time_sheet.php">
  <?php
  }
?>
