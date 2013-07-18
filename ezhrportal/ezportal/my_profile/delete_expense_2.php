<?include("config.php"); ?>

<?
	$expense_id	=$_REQUEST["expense_id"];

	$sql = "delete from expense_report where expense_id='$expense_id'";
	$result = mysql_query($sql);

	$sql = "delete from expense_report_info where expense_id='$expense_id'";
	$result = mysql_query($sql);
?>
	<br><font face="Arial" size="2" color="#4D4D4D"><b>Your expense report has been deleted.<br><br><br></font></b>
<meta http-equiv="Refresh" content="5; URL=ezq_expenses.php">
