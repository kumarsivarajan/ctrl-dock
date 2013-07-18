<?php 

include("config.php");
include("calendar.php");

?>


<h2>Generate Leave Summary Report</h2>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<form method=POST action=report_leave_search_2.php>
<tr bgcolor="#CCCCCC">	
	<td><font face=Arial size=2><b>From Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
	
	<td><font face=Arial size=2><b>To Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
	<td align="center">
	<input type=submit value="Search" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>