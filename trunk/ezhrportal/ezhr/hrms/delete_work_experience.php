<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$organization=$_REQUEST["organization"];
$from_date=$_REQUEST["from_date"];
$to_date=$_REQUEST["to_date"];

//If all the validations are successfully completed, delete the record
$sql = "delete from user_experience";
$sql = $sql . " where username='$account' and organization='$organization' and from_date='$from_date' and to_date='$to_date'";
$result = mysql_query($sql);
?>
<i><b><font size=2 color="#003366" face="Arial">The work experience details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=work_experience.php?account=<? echo $account; ?>">



