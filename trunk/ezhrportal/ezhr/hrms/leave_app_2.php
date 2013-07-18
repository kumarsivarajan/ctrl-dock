<?

include("config.php");
include("../include/date.php");
include("../include/mail.php");

$from_date=$_REQUEST['from_date'];if (strlen($from_date)== 0){$error=1;}
$from_date_print=$from_date;
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];if (strlen($to_date)== 0){$error=2;}
$to_date_print=$to_date;
$to_date=date_to_int($to_date);

$reason=$_REQUEST['reason'];if (strlen($reason)== 0){$error=4;}
$leave_category_id=$_REQUEST['leave_category_id'];
$half_day=$_REQUEST['half_day'];

$account=$_REQUEST["account"];

$approval_date=mktime();
$approval_username=$_SERVER["PHP_AUTH_USER"];

if($half_day==1){
	$to_date=$from_date+43200;
}


if ($error==0) {
    $sql = "insert into leave_form (username,from_date,to_date,reason,leave_category_id,leave_status,approval_date,approval_username)";
	$sql.=" values ('$account','$from_date','$to_date','$reason','$leave_category_id','1','$approval_date','$approval_username')";
    $result = mysql_query($sql);
	
	$sql = "select max(leave_no) from leave_form where username='$account'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$leave_id =$row[0];
	
	$diff			= $to_date-$from_date;
	if ($diff==0){$days=1;}
	if ($diff==43200){$days=0.5;}
	if ($diff>=86400){$days=($diff/86400)+1;}

	$sql="insert into lm_leave_register values ('$account','$leave_category_id','$approval_date','debit','HR Input','$days','$leave_id')";
	$result = mysql_query($sql);
	
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b>The leave record has been entered successfully. Please wait ...</font></b>
	<meta http-equiv="Refresh" content="2; URL=leave.php?account=<? echo $account; ?>">
<?	
}else{
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b><a href=javascript:history.back();>Click here to return to the previous screen to correct these errors</font></b></a>
<?
}
?>
