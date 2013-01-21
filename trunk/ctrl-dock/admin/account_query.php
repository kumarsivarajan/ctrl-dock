<?php
include("config.php"); 
if (!check_feature(1)){feature_error();exit;}
$SELECTED="ACCOUNT INFORMATION";
include("header.php");
?>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#C0C0C0>
<tr>

<form method="POST" action="account_list.php">
	<td><font face=Arial size=1 color=white><b>&nbsp; USERNAME</b></td>
	<td><input type=text name=account size=10 style="font-family: Arial; font-size: 8pt;"></td>

	<td><font face=Arial size=1 color=white><b>&nbsp; STAFF NO</b></td>
	<td><input type=text name=staff_number size=10 style="font-family: Arial; font-size: 8pt;"></td>

	<td><font face=Arial size=1 color=white><b>&nbsp; LOCATION</b></td>
	<td>
	<select size=1 name=country style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select country from office_locations group by country order by country"; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value='$row[0]'>$row[0]</option>";
		}
	?>
	</select>
	</td>

	<td>
		<font face=Arial size=1 color=white><b>&nbsp; STATUS</b>
	</td>
	<td>
	<select size=1 name=account_status style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select account_status from account_status order by account_status"; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value='$row[0]'>$row[0]</option>";
		}
	?>
	</select>
	</td>

	<td>
		<font face=Arial size=1 color=white><b>&nbsp; TYPE</b>
	</td>
	<td>
	<select size=1 name=account_type style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select * from account_type order by account_type"; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value='$row[0]'>$row[1]</option>";
		}
	?>
	</select>
	</td>

	<td align=right>
		<input type="submit" value="Query" name="Submit" style="font-family: Arial; font-size: 8pt; font-weight: bold">
	</td>
	</form>
</tr>
</table>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
	<tr>
		<td colspan=2 align=right>
				<a style="text-decoration: none" href="add_account_1.php">
				<font color="#CC0000" face="Arial" size="2"><b>Add User </font></a>
		</td>
	</tr>
</table>
