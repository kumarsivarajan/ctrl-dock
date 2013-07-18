<?include("config.php"); ?>
<?include("calendar.php");?>
<?
$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
	

// Fetch joining date of the employee
$sql = "select date_of_joining from user_personal_information where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$joining_date=date("d M Y",$row[0]);
	
?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=50%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Add a Leave Record: <?=$first_name?> <?=$last_name;?>
		<br>
		<font color=black face='Arial' size=1> Date of Joining : <? echo $joining_date; ?>
	</td>
	<td align=right>
		<a href="leave.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>

<form method=POST action=leave_app_2.php?account=<?echo $account;?>>

<table border=0 cellpadding=4 cellspacing=0 width=50%>

<tr>
	<td class=tdformlabel><b>Reason for Leave</font></b></td>
	<td align=right><textarea rows="3" name="reason" cols="42" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>
<?
$leave_summary=leave_summary($account);
?>
<tr>
	<td class=tdformlabel><b>Type of Leave</font></b></td>
	<td align=right>
			<select size=0 name=leave_category_id class=formselect>
			<?php
				for ($i=0;$i<count($leave_summary);$i++){
					$leave_type_id	=$leave_summary[$i][0];
					$leave_type		=$leave_summary[$i][1];
					$balance		=$leave_summary[$i][4];
					echo "<option value=$leave_type_id>$leave_type ($balance)</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td class=tdformlabel><b>Leave Start Date</font></b></td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
</tr>
<tr>
	<td class=tdformlabel><b>Leave End Date</font></b></td>
	<td align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
</tr>
<tr>
	<td class=tdformlabel><b>Half Day</font></b></td>
	<td align=right>
			<select size=0 name=half_day style="font-size: 8pt; font-family: Arial">
				<option value=0>No</option>
				<option value=1>Yes</option>
			</select>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit Application" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
