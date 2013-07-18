<?

include("../include/config.php");
include("../include/db.php");
include("../include/date.php"); 
include("../include/mail.php");

$action=$_REQUEST['action'];
$no=$_REQUEST['no'];
$employee=$_REQUEST["employee"];$approval_username=$employee;
$staff=$_REQUEST['staff'];
$comments=$_REQUEST['comments'];

$approval_date=mktime();
if ($action==1){$status="Approved";}
if ($action==2){$status="Rejected";}

$sql = "update leave_form set leave_status='$action', approval_date='$approval_date', approval_username='$approval_username', comments='$comments' where leave_no='$no'";
$result = mysql_query($sql);
	
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
//ezmail("$email","$name","ezQ Notification : Leave Application $status","$body");

//EMail to HR
$body="Request by $name for leave has been $status by the manager / supervisor with the following comments <br><br>";
$body.="Comments : $comments<br><br>";
$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
//ezmail("$smtp_email","$smtp_name","Leave $status : $name",$body);

?>
