<?include("config.php"); ?>
<?include("../include/date.php"); ?>


<?

$leave_no=$_REQUEST["leave_no"];
$account=$_REQUEST["account"];


$from_date=$_REQUEST['from_date'];if (strlen($from_date)== 0){$error=1;}
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);if (strlen($to_date)== 0){$error=2;}//if ($to_date<$from_date){$error=3;}

$leave_category_id=$_REQUEST['leave_category_id'];
$leave_status=$_REQUEST['leave_status'];
$last_status=$_REQUEST['last_status'];

$approval_date		= mktime();
$approval_username	= $_SESSION['username'];

$comments=$_REQUEST['comments'];
$half_day=$_REQUEST['half_day'];

if($half_day==1 && $from_date==$to_date){
	$from_date=$from_date+43200;
	$days=0.5;
}else{
	$diff			= $to_date - $from_date;
	if ($diff==0){$days=1;}
	if ($diff>=86400){$days=($diff/86400)+1;}
}

// Update the Leave Register with updated record
	
$sql="delete from lm_leave_register where leave_no='$leave_no'";
$result = mysql_query($sql);


// If the leave is in pending approval state and is being approved
if ($leave_status==1){
	$sql="insert into lm_leave_register values ('$account','$leave_category_id','$approval_date','debit','Against approval by $approval_username','$days','$leave_no')";
	$result = mysql_query($sql);
}

// If the Leave was already approved & is now being cancelled
if ($last_status==1 && $leave_status==3){
	$sql="insert into lm_leave_register values ('$account','$leave_category_id','$approval_date','credit','Against cancellation by $approval_username','$days','$leave_no')";
	$result = mysql_query($sql);
}

$sql = "update leave_form set from_date='$from_date', to_date='$to_date', leave_category_id='$leave_category_id', leave_status='$leave_status',";
$sql .= " approval_date='$approval_date',approval_username='$approval_username', comments='$comments'";
$sql .= " where leave_no='$leave_no'";
$result = mysql_query($sql);

?>
<center>
<br><font face="Arial" size="2" color="#4D4D4D"><b>The leave record has been updated. Please wait ...</font></b>
<meta http-equiv="Refresh" content="2; URL=leave.php?account=<? echo $account; ?>">
