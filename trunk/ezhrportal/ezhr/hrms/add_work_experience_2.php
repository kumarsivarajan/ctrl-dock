<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$organization=$_REQUEST["organization"];if (strlen($organization)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The name of the organization was left blank.</font></b></td></tr>";
}

// Check for validity of the Start Date of Work
$from_date=$_REQUEST["from_date"];if (strlen($from_date)<= 0){$error=2;}
$from_date=date_to_int($from_date);
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The start date of work with this organization was left blank.</font></b></td></tr>";
}

// Check for validity of the End Date of Work
$to_date=$_REQUEST["to_date"];if (strlen($to_date)<= 0){$error=3;}
$to_date=date_to_int($to_date);
if ($error==3){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The end date of work with this organization was left blank.</font></b></td></tr>";
}

if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_experience (username,organization,from_date,to_date)";
	$sql = $sql . " values('$account','$organization','$from_date','$to_date')";
	$result = mysql_query($sql);
?>	
	<meta http-equiv="Refresh" content="1; URL=work_experience.php?account=<? echo $account; ?>">
<?
}
?>



