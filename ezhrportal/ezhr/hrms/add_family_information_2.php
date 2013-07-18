<?php 
include("config.php");
include("date_to_int.php");
echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$member_name=$_REQUEST["member_name"];if (strlen($member_name)<= 0){$error=1;}
if ($error==1){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The name of the family member was left blank.</font></b></td></tr>";
}

// Check for validity of the date of birth
$member_date_of_birth=$_REQUEST["member_date_of_birth"];if (strlen($member_date_of_birth)<= 0){$error=2;}
$member_date_of_birth=date_to_int($member_date_of_birth);
if ($error==4){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The date of birth of the family member was left blank.</font></b></td></tr>";
}

$relationship=$_REQUEST["relationship"];
$member_blood_group=$_REQUEST["member_blood_group"];

$comments=$_REQUEST["comments"];
$dependent=$_REQUEST["dependent"];

if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
} else {
	//If all the validations are successfully completed, insert the record into the table
	$sql = "insert into user_family_member (username,member_name,member_date_of_birth,relationship,member_blood_group,dependent,comments)";
	$sql = $sql . " values('$account','$member_name','$member_date_of_birth','$relationship','$member_blood_group','$dependent','$comments')";
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The family member details were successfully added.</font></b></i>
	<meta http-equiv="Refresh" content="1; URL=family_list.php?account=<? echo $account; ?>">
<?
}
?>



