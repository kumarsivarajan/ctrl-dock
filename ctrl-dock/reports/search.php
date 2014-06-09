<?php
include("config.php"); 
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
	<td align=left><input class=formnputtext value="<?=$start_date;?>" name=start_date id="start_date" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>

	<td><font face=Arial size=1 color=white><b>&nbsp; GENERATE REPORT TO DATE</b></td>
	<td align=left><input class=formnputtext value="<?=$end_date;?>" name=end_date id="end_date" style="font-size: 9pt; font-family: Arial; width:165px;" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>

	<td align=right>
		<input type="submit" value="Query" name="Submit" style="font-family: Arial; font-size: 8pt; font-weight: bold">
	</td>
	</form>
</tr>
</table>

