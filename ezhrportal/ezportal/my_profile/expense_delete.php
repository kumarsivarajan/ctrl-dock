<?include("config.php"); ?>
<?include("calendar.php"); ?>
<?
	$expense_id=$_REQUEST["expense_id"];
	$entry_id=$_REQUEST["entry_id"];
	
	$sql = "delete from expense_report_info where entry_id=$entry_id";	
	$result = mysql_query($sql);
?>
<meta http-equiv="Refresh" content="0; URL=edit_expense.php?expense_id=<?echo $expense_id;?>">
