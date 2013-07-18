<?include("config.php"); ?>
<?$ACTION=" : Create New"?>
<?include("ezq_expense_header.php"); ?>
<br><br>
<center>
<form method=POST action=expense_create_2.php>

<table border=0 cellpadding=0 cellspacing=0 width=500>

<tr>
	<td align=center><font color=#4D4D4D face=Arial size=2><b>Provide a brief description for you to identify the expense report easily. <br><br></font></b></td>
</tr>
<tr>
	<td align=center><textarea rows="3" name="expense_desc" cols="100" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Create" name="Submit" class=forminputbutton>
	</td>
</tr>
</form>
</table>
