<?include("config.php"); ?>

<?
	$expense_id=$_REQUEST["expense_id"];	
	$action=$_REQUEST["action"];	
	$action_comments=$_REQUEST["action_comments"];	
	$timestamp=mktime();
	
	$sql = "update expense_report set status='PENDING VERIFICATION' where expense_id='$expense_id'";
	
	if ($action=="REJECTED"){
		$sql = "update expense_report set status='REJECTED' where expense_id='$expense_id'";
	}
	$result = mysql_query($sql);	
	

	$sql = "insert into expense_log (expense_id,action,action_by,action_date,action_comments) values ('$expense_id','$action','$employee','$timestamp','$action_comments')";
    $result = mysql_query($sql);

	$sql = "select username from expense_report where expense_id='$expense_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$staff=$row[0];


	$sql = "select official_email,first_name,last_name from user_master where username='$staff'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$email=$row[0];
	$name=$row[1]." ".$row[2];
	
	//EMail to user
	$body="Dear $row[1]<br><br>";
	$body.="Your expense report has been $action by your manager / supervisor with the following comments <br><br>";
	$body.="Comments : $action_comments<br><br>";
	$body.="<br><br>KINDLY DO NOT RESPOND TO THIS EMAIL";
	ezmail("$email","$name","ezQ Notification : Expense Report $status","$body");

?>
<meta http-equiv="Refresh" content="0; URL=ezq_expenses.php">

