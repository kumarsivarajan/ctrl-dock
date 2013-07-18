<?include("config.php"); ?>
<?$ACTION=" : Delete Expense Report"?>
<?include("ezq_expense_header.php"); ?>
<?
	$expense_id=$_REQUEST["expense_id"];	
?>
<br><br>
<center>

<form method=POST action=delete_expense_2.php>
<input type=hidden name=expense_id value='<?echo $expense_id;?>'>
<table border=0 cellpadding=4 cellspacing=0 width=98% bgcolor=#EEEEEE>
<tr>	
	<td bgcolor=#BBBBBB colspan=2 align=center><input type="submit" value="Click Here to confirm deletion of Expense Report" class='forminputbutton' style='width:400px'/>&nbsp;</td>	
</tr>

</tr>
</table>
</form>
<?include("expense_summary.php"); ?>
