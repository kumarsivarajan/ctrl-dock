<?php 
include("config.php");
if (!check_feature(21)){feature_error();exit;}

echo "<center>";

$account_type=$_REQUEST["account_type"];

// Verify validity of account and echeck for existance
if ($ACCOUNT_AS_EMAIL==1){
	$official_email=$_REQUEST["official_email"];
	$account=trim($official_email);
}
if ($ACCOUNT_AS_EMAIL==0){
	$official_email=$_REQUEST["official_email"];
	$account=trim($_REQUEST["account"]);
}
if (strlen($account)<= 0){$error=1;}
$account=strtolower($account);


$sql = "select count(*) from user_master where account='$account'";
$result = mysql_query($sql);
while ($count = mysql_fetch_row($result)) { 
	if ($count[0] > 0){
		$error=1;
	}
}
if ($error==1){
        echo "<font face=Arial size=2 color=#CC0000>Error $error : The account already exists.</font></b>";
}

// Verify validity of the password
$password1=$_REQUEST["password1"];if (strlen($password1)<= 0){$error=2;}
$password2=$_REQUEST["password2"];if (strlen($password2)<= 0){$error=2;}

if($password1!=$password2){$error=2;}

if ($error==2){
        echo "<font face=Arial size=2 color=#CC0000>Error $error : The password was either left blank or not verified correctly.</font></b>";
}

$agency_index=$_REQUEST["agency_index"];
// If the account type is an employee, set the agency index to 1
if ($account_type=="employee"){$agency_index=1;}

$staff_number=$_REQUEST["staff_number"]; 
// Check if the Name is left blank
$first_name=$_REQUEST["first_name"];if (strlen($first_name)<= 0){$error=3;}
$last_name=$_REQUEST["last_name"]; 
$business_group_index=$_REQUEST["business_group_index"]; 
if ($error==3){
    echo "<font face=Arial size=2 color=#CC0000>Error $error : The first name was left blank.</font></b>";
}


$office_index=$_REQUEST["office_index"];
$contact_phone_office=$_REQUEST["contact_phone_office"];
$contact_phone_residence=$_REQUEST["contact_phone_residence"];
$contact_phone_mobile=$_REQUEST["contact_phone_mobile"];

$contact_address=mysql_real_escape_string($_REQUEST["contact_address"]);
$permanent_address=mysql_real_escape_string($_REQUEST["permanent_address"]);

$personal_email=trim($_REQUEST["personal_email"]);
$account_status=trim($_REQUEST["account_status"]);

// Check for validity of the account expiry date
$account_expiry=$_REQUEST["account_expiry"];
if (strlen($account_expiry) > 0){
	$account_expiry=date_to_int($account_expiry);
}

$account_created_on=time();
$account_created_by=$username;

if ($error>0){
?>
	<font face="Arial" size="2" color="#003399"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a>
<?
}

//If all the validations are successfully completed, insert the record into the table
if ($error==0) {
	if ($MD5_ENABLE==1){
		$enc_password = md5($password1);
	}else{
		$enc_password = $password1;
	}
	
    $sql = "insert into user_master (username,password,staff_number,first_name,last_name,contact_phone_office,contact_phone_residence,contact_phone_mobile,contact_address,permanent_address,office_index,official_email,personal_email,account_type,account_status,account_expiry,account_created_on,account_created_by,agency_index,business_group_index) values ('$account','$enc_password','$staff_number','$first_name','$last_name','$contact_phone_office','$contact_phone_residence','$contact_phone_mobile','$contact_address','$permanent_address','$office_index','$official_email','$personal_email','$account_type','$account_status','$account_expiry','$account_created_on','$account_created_by','$agency_index','$business_group_index')";   	
	$result = mysql_query($sql);
?>
	<i><b><font size=2 color="#003366" face="Arial">The account was created successfully.</font></b></i>	
  <?php
  }
?>
