<?include_once("config.php");?>

<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>TICKET SUMMARY</b></font>
	</td>
</table>

<form method="POST" action="tkt_summary.php">
<table border=0 width=100% cellpadding="3" cellspacing="0" bgcolor=#C0C0C0>
<tr>
	<td><font face=Arial size=1 color=white><b>&nbsp;FROM DATE</b></td>
	<td><input class=formnputtext style='width:100' name=start_date id="start_date" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>

	<td><font face=Arial size=1 color=white><b>&nbsp;END DATE</b></td>
	<td><input class=formnputtext  style='width:100' name=end_date id="end_date" onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF></td>

	<td><font face=Arial size=1 color=white><b>&nbsp;TYPE / PRIORITY</b></td>
		<td>
			<select size=1 name=ticket_type_id style="font-size: 8pt; font-family: Arial">
			<?php
                echo "<option value=0></option>";
                $sql = "select ticket_type_id,ticket_type from isost_ticket_type order by ticket_type_id";
                $result = mysql_query($sql);
                while ($row = mysql_fetch_row($result)) {
                    echo "<option value='$row[0]'>$row[1]</option>";
                }
			?>
			</select>
	
			<select size=1 name=priority_id style="font-size: 8pt; font-family: Arial">
			<?php
                echo "<option value=0></option>";
                $sql = "select priority_id,priority_desc from isost_ticket_priority order by priority_id";
                $result = mysql_query($sql);
                while ($row = mysql_fetch_row($result)) {
                    echo "<option value='$row[0]'>$row[1]</option>";
                }
			?>
			</select>
		</td>
		<td><font face=Arial size=1 color=white><b>&nbsp;STATUS</b></td>
		<td>
			<select size=1 name=status style="font-size: 8pt; font-family: Arial">
			<?php
					echo "<option value=%></option>";
					echo "<option value=open>Open</option>";
					echo "<option value=closed>Closed</option>";
			?>
			</select>
		</td>
		
	<td align=right>
		<input type="submit" value="Query" name="Submit" style="font-family: Arial; font-size: 8pt; font-weight: bold">
	</td>
	</tr>
	
</table>
</form>