<?

include("config.php");
$expense_desc=$_REQUEST['expense_desc'];

if (strlen($expense_desc)>0){
	$sql = "insert into expense_report (expense_desc,username) values ('$expense_desc','$employee')";
    $result = mysql_query($sql);
}
?>
<meta http-equiv="Refresh" content="0; URL=ezq_expenses.php">
