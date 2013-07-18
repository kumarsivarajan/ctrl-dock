<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$license_no=$_REQUEST["license_no"];

//If all the validations are successfully completed, delete the record
$sql = "delete from user_driving_license";
$sql = $sql . " where username='$account' and license_no='$license_no'";
$result = mysql_query($sql);
?>
<i><b><font size=2 color="#003366" face="Arial">The driving license details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=vehicle.php?account=<? echo $account; ?>">



