<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$member_name=$_REQUEST["member_name"];

//If all the validations are successfully completed, delete the record
$sql = "delete from user_family_member";
$sql = $sql . " where username='$account' and member_name='$member_name'";
$result = mysql_query($sql);
?>
<i><b><font size=2 color="#003366" face="Arial">The family member details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=family_list.php?account=<? echo $account; ?>">



