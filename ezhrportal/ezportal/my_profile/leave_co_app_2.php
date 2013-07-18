<?

include("config.php");


$work_date=$_REQUEST['work_date'];if (strlen($work_date)== 0){$error=1;}
$work_date_print=$work_date;
$work_date=date_to_int($work_date);

$work_notes=$_REQUEST['work_notes'];if (strlen($work_notes)== 0){$error=2;}

$portal_ezq_url=$portal_ezq_url."/ezq_leave_credit.php";

if ($error==0) {
    $sql = "insert into leave_comp_off (username,work_date,work_notes,status) values ('$employee','$work_date','$work_notes','0')";
    $result = mysql_query($sql);
	
	$sql = "select official_email,first_name,last_name from user_master where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$email=$row[0];
	$name=$row[1]." ".$row[2];
	
	//EMail to user
	$body="Dear $row[1]<br><br>";
	$body.="Your request for leave credit for your time spent working on $work_date_print has been submitted for approval to your reporting manager / supervisor.";
	$body.="Once the application is approved by your manager, the leave will be credited to your account and will reflect in your account balance. You can track the status of your application at $portal_ezq_url.<br><br>";
	$body.="You will also recieve further notifications via email on the status of your request.";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($email,$name,"ezQ Notification : Leave Application",$body);
	sleep(1);
	
	// Fetch details of the supervisors
	$sql = "select direct_report_to,dot_report_to from user_organization where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$direct_report_to=$row[0];
	$dot_report_to=$row[1];
		
	$sql = "select official_email,first_name,last_name from user_master where username='$direct_report_to'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$direct_email=$row[0];
	$direct_name =$row[1]." ".$row[2];
	
	$sql = "select official_email,first_name,last_name from user_master where username='$dot_report_to'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$dot_email=$row[0];
	$dot_name =$row[1]." ".$row[2];
	
	// Send the email to the direct reporting manager
	$body="Dear $direct_name<br><br>";
	$body.="$name, who is part of your organization has submitted a request for leave credit for the work done on $work_date_print";
	$body.="This request requires action from your end. Kindly approve or reject this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($direct_email,$direct_name,"ezQ Notification : Application for Compensatory Leave Credit : $name",$body);
	sleep(1);

	
	// Send the email to the dotted line reporting manager
	$body="Dear $dot_name<br><br>";
	$body.="$name, who is a dotted line report to you has submitted a request for leave credit for the work done on $work_date_print";
	$body.="This does not require any action from you at this moment, but may require your action if the direct reporting manager / supervisor does not act upon this request. You may preview this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($dot_email,$dot_name,"ezQ Notification : Application for Compensatory Leave Credit : $name",$body);
	sleep(1);
	
	//EMail to HR
	$body="$name, has submitted a request for leave credit for the work done on $work_date_print";
	$body.="This does not require any action from you at this moment, but may require your action if the direct or dotted line reporting manager / supervisor does not act upon this request.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($smtp_email,$smtp_name,"Application for Compensatory Leave Credit : $name",$body);
	sleep(1);
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b>Your request for credit of compensatory leave to your account has been submitted for approval.<br><br><br> You will get a notification when it is reviewed by your manager / supervisor.</font></b>
<?	
}else{
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a>
<?
}
?>
