<?php
include("config.php"); 
include("calendar.php"); 
?>
<center>

<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>REPORTS</b></font>
	</td>
</table>

<br>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#C0C0C0>
<tr>
<form method="POST" action="report.php">
	<td><font face=Arial size=1 color=white><b>&nbsp; GENERATE REPORT FROM DATE</b></td>
	<td align=left><input class=formnputtext style='width:100' name=start_date id="start_date" onclick="fPopCalendar('start_date')" readonly></td>

	<td><font face=Arial size=1 color=white><b>&nbsp; GENERATE REPORT TO DATE</b></td>
	<td align=left><input class=formnputtext  style='width:100' name=end_date id="end_date" onclick="fPopCalendar('end_date')" readonly></td>

	<td align=right>
		<input type="submit" value="Query" name="Submit" style="font-family: Arial; font-size: 8pt; font-weight: bold">
	</td>
	</form>
</tr>
</table>

