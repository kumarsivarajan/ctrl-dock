<?php 
include("config.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$organization=$_REQUEST["organization"];if (strlen($organization)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The name of the organization was left blank.</font></b></td></tr>";
}

$award=$_REQUEST["award"];if (strlen($award)<= 0){$error=2;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The details of the award was not provided</font></b></td></tr>";
}


if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_awards (username,organization,award)";
	$sql = $sql . " values('$account','$organization','$award')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The Award details have been successfully updated</font></b></i>
	<meta http-equiv="Refresh" content="1; URL=awards.php?account=<? echo $account; ?>">
<?
}
?>



