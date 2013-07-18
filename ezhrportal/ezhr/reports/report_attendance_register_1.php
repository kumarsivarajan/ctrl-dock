<?php 

include("config.php");
include("calendar.php");
include("../include/date.php"); 
?>
<center>

<h2>Generate Attendance Register</h2>

<table border=1 width=700 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<form method=POST action=report_attendance_register_2.php>
<tr bgcolor="#CCCCCC">	
	<td><font face=Arial size=2><b>From Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" onclick="fPopCalendar('from_date')"></td>

	
	<td><font face=Arial size=2><b>To Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" onclick="fPopCalendar('to_date')"></td>
	
	
	<td><font face=Arial size=2><b>Account Status</td>
	<td>
	<select size=1 name=account_status style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select account_status from account_status order by account_status"; 	
			$result = mysql_query($sql);
			while ($row = mysql_fetch_row($result)) {
        		echo "<option value=$row[0]>$row[0]</option>";
			}
	?>
	</select>
	</td>
	<td>
	<input type=submit value="Search" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>