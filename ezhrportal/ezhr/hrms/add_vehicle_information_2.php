<?php 
include("config.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];

$vehicle_type=$_REQUEST["vehicle_type"];if (strlen($vehicle_type)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The type of vehicle was left blank.</font></b></td></tr>";
}

$vehicle_make=$_REQUEST["vehicle_make"];if (strlen($vehicle_make)<= 0){$error=2;}
if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The make of the vehicle was left blank.</font></b></td></tr>";
}

$vehicle_no=$_REQUEST["vehicle_no"];if (strlen($vehicle_no)<= 0){$error=3;}
if ($error==3){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The vehicle number was left blank.</font></b></td></tr>";
}



if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_vehicle (username,vehicle_type,vehicle_make,vehicle_no)";
	$sql = $sql . " values('$account','$vehicle_type','$vehicle_make','$vehicle_no')";
	$result = mysql_query($sql);
?>	
	<meta http-equiv="Refresh" content="1; URL=vehicle.php?account=<? echo $account; ?>">
<?
}
?>



