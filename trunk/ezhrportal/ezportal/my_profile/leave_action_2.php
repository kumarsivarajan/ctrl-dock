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

$sql = "update leave_form set leave_status='$action', approval_date='$approval_date', approval_username='$approval_username', comments='$comments' where leave_no='$no'";
$result = mysql_query($sql);


// Update Leave Register with debit entry if the leave is approved
if ($action==1){
	$sql="select leave_category_id,from_date,to_date from leave_form where leave_no='$no'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$leave_type_id	= $row[0];
	$from_date		= $row[1];
	$to_date		= $row[2];
	$diff			= $to_date-$from_date;

	if ($diff==0){$days=1;}
	if ($diff==43200){$days=0.5;}
	if ($diff>=86400){$days=($diff/86400)+1;}

	$sql="insert into lm_leave_register values ('$staff','$leave_type_id','$approval_date','debit','Against leave approved','$days','$no')";
	$result = mysql_query($sql);
}

	
$sql = "select official_email,first_name,last_name from user_master where username='$staff'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$email=$row[0];
$name=$row[1]." ".$row[2];
	
//EMail to user
$body="Dear $row[1]<br><br>";
$body.="Your request for leave has been $status by your manager / supervisor with the following comments <br><br>";
$body.="Comments : $comments<br><br>";
$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
ezmail("$email","$name","ezQ Notification : Leave Application $status","$body");

//EMail to HR
$body="Request by $name for leave has been $status by the manager / supervisor with the following comments <br><br>";
$body.="Comments : $comments<br><br>";
$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
ezmail("$smtp_email","$smtp_name","Leave $status : $name",$body);

?>

<br><font face="Arial" size="2" color="#4D4D4D"><b>Please wait while your approval / rejection is submitted ..</font></b>
<meta http-equiv="Refresh" content="3; URL=ezq_leave.php">
