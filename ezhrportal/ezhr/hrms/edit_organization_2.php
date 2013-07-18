<?php 
include("config.php");

$dot_report_to=$_REQUEST["dot_report_to"];
$direct_report_to=$_REQUEST["direct_report_to"];
$designation=$_REQUEST["designation"];
$business_group_index=$_REQUEST["business_group_index"];
$grade_id=$_REQUEST["grade_id"];

$account=$_REQUEST["account"];

//If all the validations are successfully completed, update the record 
$sql = "select count(*) from user_organization where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[0]<=0){
	$sql = "insert into user_organization (username,title,direct_report_to,dot_report_to)";
	$sql = $sql . " values('$account','$designation','$direct_report_to','$dot_report_to')";	
	$result = mysql_query($sql);
} else {
	$sql = "update user_organization set title='$designation', direct_report_to='$direct_report_to',dot_report_to='$dot_report_to'";
	$sql = $sql . " where username='$account'";
	$result = mysql_query($sql);
	
	$sql = "update user_master set business_group_index='$business_group_index', grade_id='$grade_id'";
	$sql = $sql . " where username='$account'";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="Refresh" content="1; URL=user_home.php?account=<? echo $account; ?>">


