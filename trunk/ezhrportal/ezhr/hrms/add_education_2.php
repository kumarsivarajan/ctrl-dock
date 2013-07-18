<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$type_of_course =$_REQUEST["type_of_course"];
$name_of_course=$_REQUEST["name_of_course"];
$university_institution =$_REQUEST["university_institution"];
$year_of_completion=$_REQUEST["year_of_completion"];

$sql = "insert into user_education (username,type_of_course,name_of_course,university_institution,year_of_completion)";
	$sql = $sql . " values('$account','$type_of_course','$name_of_course','$university_institution','$year_of_completion')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The Education details have been successfully updated</font></b></i>
	<meta http-equiv="Refresh" content="1; URL=education.php?account=<? echo $account; ?>">



