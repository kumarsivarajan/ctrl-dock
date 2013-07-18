<form method="POST" action="list.php">
<table border=0 width=100% cellpadding="4" cellspacing="0" >
<tr bgcolor=#CCCCCC>

	<td width=90 align=left><font face=Arial size=1 color=black><b>EXPENSE STATUS</b></td>
	<td width=80 align=right>
		<select size=1 name=status class=formselect>
			<option value=%></option>
			<option value='SUBMITTED'>SUBMITTED</option>
			<option value='APPROVED'>APPROVED</option>
			<option value='VERIFIED'>VERIFIED</option>
			<option value='CLEARED'>CLEARED</option>			
			<option value='REJECTED'>REJECTED</option>			
		</select>
	</td>
	<td width=40 align=left><font face=Arial size=1 color=black><b>STAFF</b></td>
	<td width=100 align=right>
		<select size=1 name=staff class=formselect>
				<?php
					echo "<option value=%></option>";
						$sql = "select username,first_name,last_name from user_master order by first_name"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value='$row[0]'>$row[1] $row[2]</option>";
					}
				?>
		</select>
	</td>
	<td width=60><font color=black  face=Arial size=1><b>FROM DATE</font></b></td>
	<td width=60 align=right><input class=forminputtext style="width:60" name=from_date readonly id="from_date" onclick="fPopCalendar('from_date')"></td>
	<td width=60><font color=black  face=Arial size=1><b>TO DATE</font></b></td>
	<td width=60 align=right><input class=forminputtext style="width:60" name=to_date readonly id="to_date" onclick="fPopCalendar('to_date')"></td>
	<td>&nbsp;</td>
	<td width=70 align=center>
	<input type="submit" value="Search" name="Submit" class=forminputbutton>
	</td>
</tr>
</table>
</form>
