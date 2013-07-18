<?include("config.php"); ?>
<?$ACTION=" : Apply";?>
<?include("ezq_leave_credit_header.php");?>

<br><br>
<form method=POST action=leave_co_app_2.php>

<table border=0 cellpadding=0 cellspacing=0 width=450>

</tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>For Work On</font></b></td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=work_date id="work_date" readonly onclick="fPopCalendar('work_date')"></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>

<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Notes</font></b></td>
	<td align=right><textarea rows="3" name="work_notes" cols="42" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit Application" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
