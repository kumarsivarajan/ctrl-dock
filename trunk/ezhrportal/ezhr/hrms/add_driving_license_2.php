<?php 
include("config.php");
include("date_to_int.php");

echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];

$license_no=$_REQUEST["license_no"];if (strlen($license_no)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The license number was left blank.</font></b></td></tr>";
}

$license_issue_date=$_REQUEST["license_issue_date"];if (strlen($license_issue_date)<= 0){$error=2;}
if (strlen($license_issue_date)>0){$license_issue_date=date_to_int($license_issue_date);}
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The license issue date was left blank.</font></b></td></tr>";
}

$license_valid_till=$_REQUEST["license_valid_till"];if (strlen($license_valid_till)<= 0){$error=3;}
if (strlen($license_valid_till)>0){$license_valid_till=date_to_int($license_valid_till);}
if ($error==3){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The license validity period was left blank.</font></b></td></tr>";
}

$category=$_REQUEST["category"];

if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_driving_license (username,license_no,license_issue_date,license_valid_till,category)";
	$sql = $sql . " values('$account','$license_no','$license_issue_date','$license_valid_till','$category')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The license details were successfully added.</font></b></i>
	<meta http-equiv="Refresh" content="2; URL=vehicle.php?account=<? echo $account; ?>">
<?
}
?>



