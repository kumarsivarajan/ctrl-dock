<?

include("config.php");

$from_date=$_REQUEST['from_date'];if (strlen($from_date)== 0){$error=1;}
$from_date_print=$from_date;
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];if (strlen($to_date)== 0){$error=2;}
$to_date_print=$to_date;
$to_date=date_to_int($to_date);

$reason=$_REQUEST['reason'];if (strlen($reason)== 0){$error=4;}
$reason=str_replace("'","",$reason);
$reason=str_replace("(","",$reason);
$reason=str_replace(")","",$reason);
$reason=str_replace("\"","",$reason);
$leave_category_id=$_REQUEST['leave_category_id']; if (strlen($leave_category_id)==0){$error=5;}
$half_day=$_REQUEST['half_day'];

$leave_summary=leave_summary($account);

$no_days=($to_date-$from_date)/86400;

for ($i=0;$i<count($leave_summary);$i++){
	$leave_type_id	=$leave_summary[$i][0];
	$leave_type		=$leave_summary[$i][1];
	$balance		=$leave_summary[$i][4];
	if ($leave_category_id==$leave_type_id && $no_days>$balance ){ 
		$error=6;
	}
}

$application_date=mktime();

if($half_day==1){
	$from_date=$from_date+43200;
}


$portal_ezq_url=$portal_ezq_url."/ezq_leave.php";

if ($error==0) {
    $sql = "insert into leave_form (username,from_date,to_date,reason,leave_category_id,leave_status,application_date) values ('$employee','$from_date','$to_date','$reason','$leave_category_id','0','$application_date')";
    $result = mysql_query($sql);
	
	$sql = "select official_email,first_name,last_name from user_master where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$email=$row[0];
	$name=$row[1]." ".$row[2];
	
	//EMail to user
	$body="Dear $row[1]<br><br>";
	$body.="Your request for leave starting $from_date_print until $to_date_print has been submitted for approval to your reporting manager / supervisor.";
	$body.="You can track the status of your application at $portal_ezq_url.<br><br>";
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
	
	// If its a half day leave then mention the same
	$half_day_body="";
	if($half_day==1){
		$half_day_body="half day";
	}
	
	// Send the email to the direct reporting manager
	$body="Dear $direct_name<br><br>";	
	$body.="$name, who is part of your organization has submitted a request for $half_day_body leave starting $from_date_print until $to_date_print.";
	$body.="This request requires action from your end. Kindly approve or reject this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($direct_email,$direct_name,"ezQ Notification : Leave Application : $name",$body);
	sleep(1);

	
	// Send the email to the dotted line reporting manager
	$body="Dear $dot_name<br><br>";
	$body.="$name, who is a dotted line report to you has submitted a request for $half_day_body leave starting $from_date_print until $to_date_print.";
	$body.="This does not require any action from you at this moment, but may require your action if the direct reporting manager / supervisor does not act upon this request. You may preview this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($dot_email,$dot_name,"ezQ Notification : Leave Application : $name",$body);
	sleep(1);
	
	//EMail to HR
	$body="$name, has submitted a request for $half_day_body leave starting $from_date_print until $to_date_print.";
	$body.="This does not require any action from you at this moment, but may require your action if the direct or dotted line reporting manager / supervisor does not act upon this request.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($smtp_email,$smtp_name,"Leave Application : $name",$body);
	sleep(1);
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b>Your leave application has been submitted for approval.<br><br><br> You will get a notification when it is reviewed by your manager / supervisor.</font></b>
<?	
}else{
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a>
<?
}
?>
