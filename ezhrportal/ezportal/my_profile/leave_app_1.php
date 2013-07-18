<?include("config.php"); ?>

<?$ACTION=" : Apply"?>
<?include("ezq_leave_header.php"); ?>
<br><br>
<center>
<form method=POST action=leave_app_2.php>

<table border=0 cellpadding=0 cellspacing=0 width=450>

<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Reason for Leave</font></b></td>
	<td align=right><textarea rows="3" name="reason" cols="42" class=formtextarea></textarea></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>

<?
$leave_summary=leave_summary($employee);
?>


<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Type of Leave</font></b></td>
	<td align=right>
			<select size=0 name=leave_category_id class=formselect>
			<?php
				for ($i=0;$i<count($leave_summary);$i++){
					$leave_type_id	=$leave_summary[$i][0];
					$leave_type		=$leave_summary[$i][1];
					$balance		=$leave_summary[$i][4];
					if ($balance > 0){
						echo "<option value=$leave_type_id>$leave_type ($balance)</option>";
					}
				}
			?>
		</select>
	</td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>



</tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Leave Start Date</font></b></td>
	<td  align=right><input class=forminputtext name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>

</tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>Leave End Date</font></b></td>
	<td  align=right><input class=forminputtext name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>

<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>Half Day</font></b></td>
	<td align=right>
			<select size=0 name=half_day class=formselect>
				<option value=0>No</option>
				<option value=1>Yes</option>
			</select>
	</td>
</tr>
<tr><td bgcolor=white colspan=2><font face=Arial size=2 color=White>&nbsp;</td></tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit Application" name="Submit" class=forminputbutton>
	</td>
</tr>
</form>
</table>
