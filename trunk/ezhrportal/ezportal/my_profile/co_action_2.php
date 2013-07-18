<?

include("config.php");

$action=$_REQUEST['action'];
$no=$_REQUEST['no'];
$staff=$_REQUEST['staff'];
$approval_date=mktime();
$approval_username=$employee;
$comments=$_REQUEST['comments'];
if ($action==1){$status="Approved";}
if ($action==2){$status="Rejected";}

$sql = "update leave_comp_off set status='$action', approval_date='$approval_date', approval_username='$approval_username', comments='$comments' where off_no='$no'";
$result = mysql_query($sql);
	
$sql = "select official_email,first_name,last_name from user_master where username='$staff'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$email=$row[0];
$name=$row[1]." ".$row[2];

// Update Leave Register with debit entry if the leave is approved
if ($action==1){
	$sql="select work_date from leave_comp_off where off_no='$no'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$leave_type_id	= 4; // By default applies to compensatory leave credit
	$work_date		= date('d M Y',$row[0]);
	$days			= 1; // Compensatory leave credit is given against a single day's work

	$sql="insert into lm_leave_register values ('$staff','$leave_type_id','$approval_date','credit','Approved Leave Credit for $work_date','$days','$no')";
	$result = mysql_query($sql);
}

	
//EMail to user
$body="Dear $row[1]<br><br>";
$body.="Your request for leave credit has been $status by your manager / supervisor with the following comments <br><br>";
$body.="Comments : $comments<br><br>";
$body.="Leave has been credited to your account.<br><br>";
$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
ezmail("$email","$name","ezQ Notification : Application for Compensatory Leave Credit : $status","$body");

//EMail to HR
$body="Request by $name for leave credit has been $status by the manager / supervisor with the following comments <br><br>";
$body.="Comments : $comments<br><br>";
$body.="Leave has been credited to the account.<br><br>";
$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
ezmail("$smtp_email","$smtp_name","Application for Compensatory Leave Credit $status : $name",$body);

?>

<br><font face="Arial" size="2" color="#4D4D4D"><b>Please wait while your approval / rejection is submitted ..</font></b>
<meta http-equiv="Refresh" content="3; URL=ezq_leave_credit.php">
