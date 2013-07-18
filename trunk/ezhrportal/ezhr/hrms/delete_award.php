<?php 
include("config.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$index=$_REQUEST["index"];

//If all the validations are successfully completed, delete the record
$sql = "delete from user_awards";
$sql = $sql . " where award_index='$index'";
$result = mysql_query($sql);

?>
<i><b><font size=2 color="#003366" face="Arial">The award details were deleted.</font></b></i>
<meta http-equiv="Refresh" content="1; URL=awards.php?account=<? echo $account; ?>">



