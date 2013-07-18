<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$vehicle_no=$_REQUEST["vehicle_no"];

//If all the validations are successfully completed, delete the record
$sql ="delete from user_vehicle";
$sql.=" where username='$account' and vehicle_no='$vehicle_no'";
$result = mysql_query($sql);
?>
<i><b><font size=2 color="#003366" face="Arial">The vehicle details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="2; URL=vehicle.php?account=<?=$account;?>">



