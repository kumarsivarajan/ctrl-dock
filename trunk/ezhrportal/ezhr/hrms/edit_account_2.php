<?php 
include("config.php");

$account=$_REQUEST["account"];
$office_index=$_REQUEST["office_index"];
$contact_phone_office=$_REQUEST["contact_phone_office"];
$contact_phone_residence=$_REQUEST["contact_phone_residence"];
$contact_phone_mobile=$_REQUEST["contact_phone_mobile"];

$contact_address=$_REQUEST["contact_address"];
$permanent_address=$_REQUEST["permanent_address"];

$official_email=$_REQUEST["official_email"];
$personal_email=$_REQUEST["personal_email"];

 
//If all the validations are successfully completed, update the record 
$sql = "update user_master set contact_phone_office='$contact_phone_office',contact_phone_residence='$contact_phone_residence',contact_phone_mobile='$contact_phone_mobile',contact_address='$contact_address',permanent_address='$permanent_address',office_index='$office_index',official_email='$official_email',personal_email='$personal_email' where username='$account'";
$result=mysql_query($sql);
	
?>
<meta http-equiv="Refresh" content="1; URL=user_home.php?account=<? echo $account; ?>">
	
