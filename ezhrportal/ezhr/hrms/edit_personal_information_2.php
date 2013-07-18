<?php 
include("config.php");
include("date_to_int.php");

$date_of_joining=$_REQUEST["date_of_joining"];
if (strlen($date_of_joining)>0){$date_of_joining=date_to_int($date_of_joining);}

$date_of_leaving=$_REQUEST["date_of_leaving"];
if (strlen($date_of_leaving)>0){$date_of_leaving=date_to_int($date_of_leaving);}


$account=$_REQUEST["account"];

$gender=$_REQUEST["gender"];
$date_of_birth=$_REQUEST["date_of_birth"];
if (strlen($date_of_birth)>0){$date_of_birth=date_to_int($date_of_birth);}

$blood_group=$_REQUEST["blood_group"];

$marital_status=$_REQUEST["marital_status"];
$date_of_marriage=$_REQUEST["date_of_marriage"];
if (strlen($date_of_marriage)>0){$date_of_marriage=date_to_int($date_of_marriage);}

$passport_number=$_REQUEST["passport_number"];
$passport_issue_location=$_REQUEST["passport_issue_location"];

$passport_issue_date=$_REQUEST["passport_issue_date"];
if (strlen($passport_issue_date)>0){$passport_issue_date=date_to_int($passport_issue_date);}

$passport_valid_till=$_REQUEST["passport_valid_till"];
if (strlen($passport_valid_till)>0){$passport_valid_till=date_to_int($passport_valid_till);}

$first_name=$_REQUEST["first_name"];
$last_name=$_REQUEST["last_name"]; 
$staff_number=$_REQUEST["staff_number"];

$leave_policy_id=$_REQUEST["leave_policy_id"];


//If all the validations are successfully completed, update the record 
$sql = "select count(*) from user_personal_information where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[0]<=0){
	$sql = "insert into user_personal_information (date_of_joining,username,gender,date_of_birth,blood_group,marital_status,date_of_marriage,passport_number,passport_issue_location,passport_issue_date,passport_valid_till,date_of_leaving)";
	$sql = $sql . " values('$date_of_joining','$account','$gender','$date_of_birth','$blood_group','$marital_status','$date_of_marriage','$passport_number','$passport_issue_location','$passport_issue_date','$passport_valid_till','$date_of_leaving')";
	$result = mysql_query($sql);
	
} else {
	$sql = "update user_master set first_name='$first_name', last_name='$last_name',staff_number='$staff_number' where username='$account'";
	$result = mysql_query($sql);
	
	$sql = "update user_personal_information set date_of_joining='$date_of_joining',gender='$gender',date_of_birth='$date_of_birth',blood_group='$blood_group',marital_status='$marital_status',date_of_marriage='$date_of_marriage',passport_number='$passport_number',passport_issue_location='$passport_issue_location',passport_issue_date='$passport_issue_date',passport_valid_till='$passport_valid_till',date_of_leaving='$date_of_leaving'";
	$sql = $sql . " where username='$account'";
	$result = mysql_query($sql);
}

//Update Leave Policy Information
$sql = "select count(*) from lm_user_leave_policy where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[0]<=0){
	$sql = "insert into lm_user_leave_policy values ('$account','$leave_policy_id')";
	$result = mysql_query($sql);
} else {
	$sql = "update lm_user_leave_policy set policy_id='$leave_policy_id' where username='$account'";
	$result = mysql_query($sql);
}

?>
<meta http-equiv="Refresh" content="1; URL=user_home.php?account=<? echo $account; ?>">


