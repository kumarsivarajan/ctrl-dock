<?include("config.php"); ?>



<?
	$portal_ezq_url=$portal_ezq_url."/ezq_expenses.php";
	$expense_id	=$_REQUEST["expense_id"];
	$timestamp	=mktime();

	$sql = "update expense_report set status='PENDING APPROVAL' where expense_id='$expense_id'";
    $result = mysql_query($sql);

	$sql = "insert into expense_log (expense_id,action,action_by,action_date) values ('$expense_id','SUBMITTED','$employee','$timestamp')";
    $result = mysql_query($sql);

	$sql = "select official_email,first_name,last_name from user_master where username='$employee'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$email=$row[0];
	$name=$row[1]." ".$row[2];
	
	//EMail to user
	$body="Dear $row[1]<br><br>";
	$body.="Your expense report has been submitted for approval to your reporting manager / supervisor.";
	$body.="You can track the status of your application at $portal_ezq_url.<br><br>";
	$body.="You will also recieve further notifications via email on the status of your request.";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($email,$name,"ezQ Notification : Expense Report",$body);
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
	$body.="$name, who is part of your organization has submitted an expense report. ";
	$body.="This request requires action from your end. Kindly approve or reject this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($direct_email,$direct_name,"ezQ Notification : Expense Report : $name",$body);
	sleep(1);
	
	// Send the email to the dotted line reporting manager
	$body="Dear $dot_name<br><br>";
	$body.="$name, who is a dotted line report to you has submitted an expense report. ";
	$body.="This does not require any action from you at this moment, but may require your action if the direct reporting manager / supervisor does not act upon this request. You may preview this request at $portal_ezq_url.<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail($dot_email,$dot_name,"ezQ Notification : Expense Report : $name",$body);
	sleep(1);
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b>Your expense report has been submitted for approval.<br><br><br> You will get a notification when it is reviewed by your manager / supervisor.</font></b>
<meta http-equiv="Refresh" content="5; URL=ezq_expenses.php">
