<?php 
include("config.php");
include("date_to_int.php");

$account=$_REQUEST["account"];
$country=$_REQUEST["country"];
$visa_type=$_REQUEST["visa_type"];
$valid_till=$_REQUEST["valid_till"];


//If all the validations are successfully completed, delete the record
$sql = "delete from user_visa_information";
$sql = $sql . " where username='$account' and visa_type='$visa_type' and valid_till='$valid_till'";
$result = mysql_query($sql);
?>
<center><i><b><font size=2 color="#003366" face="Arial">The visa details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=travel.php?account=<? echo $account; ?>">



