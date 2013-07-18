<?php 
include("config.php");
include("date_to_int.php");

$account=$_REQUEST["account"];
$country_visited=$_REQUEST["country_visited"];
$year_of_visit=$_REQUEST["year_of_visit"];

//If all the validations are successfully completed, delete the record
$sql = "delete from user_overseas_travel";
$sql = $sql . " where username='$account' and country_visited='$country_visited' and year_of_visit='$year_of_visit'";
$result = mysql_query($sql);
?>
<center><i><b><font size=2 color="#003366" face="Arial">The travel details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=travel.php?account=<? echo $account; ?>">



