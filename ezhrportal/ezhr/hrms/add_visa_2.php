<?php 
include("config.php");
include("date_to_int.php");

echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];

$country=$_REQUEST["country"];if (strlen($country)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The country number was left blank.</font></b></td></tr>";
}

$visa_type=$_REQUEST["visa_type"];if (strlen($visa_type)<= 0){$error=2;}
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The type of visa was left blank.</font></b></td></tr>";
}

$valid_till=$_REQUEST["valid_till"];if (strlen($valid_till)<= 0){$error=3;}
if (strlen($valid_till)>0){$valid_till=date_to_int($valid_till);}
if ($error==3){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The validity period of the visa was left blank.</font></b></td></tr>";
}

if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_visa_information (username,country,visa_type,valid_till)";
	$sql = $sql . " values('$account','$country','$visa_type','$valid_till')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The visa details were successfully updated</font></b></i>
	<meta http-equiv="Refresh" content="2; URL=travel.php?account=<? echo $account; ?>">
<?
}
?>



