<?php 
include("config.php");
if (!check_feature(11)){feature_error();exit;} 

$office_index=$_REQUEST["office_index"];

$sql_1 = "select * from asset where office_index=$office_index";
$result_1 = mysql_query($sql_1);
$result_1_count=mysql_num_rows($result_1);

$sql_2 = "select * from user_master where office_index=$office_index";
$result_2= mysql_query($sql_2);
$result_2_count=mysql_num_rows($result_2);


if($result_1_count or $result_2_count)
{
	echo "<script type='text/javascript'>";
		echo "alert('Cannot Delete Location; There are Assets / Users associated with this Location')";
	echo "</script>";
}
else
{
	$sql = "delete from office_locations where office_index='$office_index'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
}


?>
<meta http-equiv="Refresh" content="0; URL=office_locations.php">