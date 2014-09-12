<?php 
include("config.php");
if (!check_feature(3)){feature_error();exit;}

echo "<center><table border=0 width=50%>";

$account=$_REQUEST["account"];
$account_type=$_REQUEST["account_type"];
$agency_index=$_REQUEST["agency_index"];

// Verify validity of the password

$password1=$_REQUEST["password1"];
$password2=$_REQUEST["password2"];
if(strlen($password1)>0 && strlen($password2)>0){
	if($password1!=$password2){$error=2;}
}

if ($error==2){
        echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The password was not verified correctly.</font></b></td></tr>";
}

$staff_number=$_REQUEST["staff_number"]; 
// Check if the Name is left blank
$first_name=$_REQUEST["first_name"];if (strlen($first_name)<= 0){$error=3;}
$last_name=$_REQUEST["last_name"]; 
$business_group_index=$_REQUEST["business_group_index"]; 
if ($error==3){
    echo "<tr><td><font face=Arial size=2 color=#CC0000>Error $error : The first name was left blank.</font></b></td></tr>";
}


$office_index=$_REQUEST["office_index"];
$contact_phone_office=$_REQUEST["contact_phone_office"];
$contact_phone_residence=$_REQUEST["contact_phone_residence"];
$contact_phone_mobile=$_REQUEST["contact_phone_mobile"];

$contact_address=mysql_real_escape_string($_REQUEST["contact_address"]);
$permanent_address=mysql_real_escape_string($_REQUEST["permanent_address"]);

$personal_email=trim($_REQUEST["personal_email"]);
$official_email=trim($_REQUEST["official_email"]);

$account_status=$_REQUEST["account_status"];

// check if any assets are assigned to the user. If yes, then all assets should be un-assigned before making this user obsolete
$sub_sql	="select assetid from asset where employee='$account'";
$sub_result	=mysql_query($sub_sql);
$count		=mysql_num_rows($sub_result);
if ($count>0){
?>
	<tr><td align=center><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>The user has assets which are assigned in his / her name. <br><br>Please re-assign / un-assign the same before making this user obsolete </font></b></a></td></tr></table>
<?
}else{

// Check for validity of the account expiry date
$account_expiry=$_REQUEST["account_expiry"];
if (strlen($account_expiry)> 0){
	$account_expiry=date_to_int($account_expiry);
}
  
if ($error>0){
?>
	<tr><td><font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a></td></tr></table>
<?
}

//If all the validations are successfully completed, update the record 
if ($error==0) {
	if ($MD5_ENABLE==1){
		$enc_password = md5($password1);
	}else{
		$enc_password = $password1;
	}
    $sql = "update user_master set staff_number='$staff_number',first_name='$first_name',last_name='$last_name',contact_phone_office='$contact_phone_office',contact_phone_residence='$contact_phone_residence',contact_phone_mobile='$contact_phone_mobile',contact_address='$contact_address',permanent_address='$permanent_address',office_index='$office_index',official_email='$official_email',personal_email='$personal_email',account_type='$account_type',account_status='$account_status',account_expiry='$account_expiry', business_group_index='$business_group_index',agency_index='$agency_index' where username='$account'";
	$result=mysql_query($sql);
	
	if(strlen($password1)>0 && strlen($password2)>0){
		$sql="update user_master set password='$enc_password' where username='$account'";
		$result=mysql_query($sql);
	}
	
?>
	<i><b><font size=2 color="#003366" face="Arial">The account was updated successfully.</font></b></i>
		
  <?php
  }
 }
?>
