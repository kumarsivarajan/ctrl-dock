<?php
include_once("config.php");
include_once("calendar.php");
?>
<script language="javascript" src="ajaxSubmit.js" type="text/javascript"></script>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="200" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>Engineer Reports</b></font>
	</td>
	</tr>
</table>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#C0C0C0>
<form method="POST" name="form" action="">
<tr>
				<td width=100 align=right><font face=Arial size=1 color=white><b>AGENCY</b></td>
				<td>
				<select size=1 name=agencyid id=agencyid style="font-size: 8pt; font-family: Arial; width:325px;" onchange="filterstaff('staff',this.value);">
				<?php
					echo "<option value=''>Select Agency</option>";
					$sql="select a.agency_index,b.name";
					$sql.=" from rim_master a, agency b,agency_rim c,agency_status d where a.agency_index=b.agency_index and a.agency_index=c.agency_index and a.agency_index=d.agency_index and d.status='Active' order by name";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value=$row[0]>$row[1]</option>";
					}
				?>
				</select>
				</td>
				
				<td width=100 align=right><font face=Arial size=1 color=white><b>STAFF</b></td>
				<td>
				<select size=1 name=staff id=staff style="font-size: 8pt; font-family: Arial; width:170px;" onchange="filteragency('agencyid',this.value);">
				<?php
					echo "<option value=''>Select Staff</option>";
						$sql = "select distinct ar.username,um.first_name,um.last_name from agency_resource ar,user_master um where ar.username=um.username and um.account_status='Active' order by um.first_name"; 	
					$result = mysql_query($sql);
					while ($row = mysql_fetch_row($result)) {
							echo "<option value=$row[0]>$row[1] $row[2]</option>";
					}
				?>
				</select>
				</td>
				<td width=100 align=right></td><td><input type="button" value="Show Unassigned Tickets" name="unassigned" style="font-family: Arial; font-size: 8pt; font-weight: bold;" onclick="loadunassigned();">
				</td>
				<td colspan=11 align=right>
					<input type="button" onclick="window.location=''" value="Reset  " style="font-family: Arial; font-size: 8pt; font-weight: bold">
				</td>
</tr>
<tr>
				<td width=100 align=right><font face=Arial size=1 color=white><b>START DATE</b></td>
				<td ><input class=formnputtext style='width:100' name=start_date id="start_date" onclick="fPopCalendar('start_date')" readonly></td>

				<td width=100 align=right><font face=Arial size=1 color=white><b>END DATE</b></td>
				<td ><input class=formnputtext  style='width:100' name=end_date id="end_date" onclick="fPopCalendar('end_date')" readonly></td>
				
				<td width=100 align=right><font face=Arial size=1 color=white><b>STATUS</b></td>
				<td ><select size=1 name=status id=status style="font-size: 8pt; font-family: Arial; width:100px;">
				<option value="">Select Status</option>
				<option value="open">Open</option>
				<option value="closed">Closed</option>
				<option value="transfered">Transfered</option>
				</select></td>
				<td colspan=10 align=center>
					<input type="button" value="Search" name="search" style="font-family: Arial; font-size: 8pt; font-weight: bold;" onclick="loadprogressbar();">
				</td>
</tr>
</form>				
</table>
<div id="loadcontent"></div>
