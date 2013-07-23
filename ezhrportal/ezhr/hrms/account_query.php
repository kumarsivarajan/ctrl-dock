<?php
include("config.php"); 
if (!check_feature(1)){feature_error();exit;}
?>
<center>
<table border=0 width=100% cellpadding="0" cellspacing="0" >
<tr>
	<td align=left><h2>STAFF INFORMATION</h2></td>
	<td align=right><a href=add_account_1.php><font face="Arial" color="#336699" size="1"><b>ADD STAFF ACCOUNT</b></font></td>
</tr>
</table>

<table border=0 width=100% cellpadding="0" cellspacing="0" bgcolor=#CCCCCC>
<tr>

<form method="POST" action="account_list.php">
	<td><font face=Arial size=1 color=#333333><b>&nbsp;USERNAME</b></td>
	<td><input type=text name=username size=10 style="font-family: Arial; font-size: 8pt;"></td>

	<td><font face=Arial size=1 color=#333333><b>&nbsp;STAFF NO.</b></td>
	<td><input type=text name=staff_number size=10 style="font-family: Arial; font-size: 8pt;"></td>

	<td><font face=Arial size=1 color=#333333><b>&nbsp;REGION</b></td>
	<td>
	<select size=1 name=country style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select country from office_locations group by country order by country"; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value=$row[0]>$row[0]</option>";
		}
	?>
	</select>
	</td>


	<td>
		<font face=Arial size=1 color=#333333><b>&nbsp;STATUS</b>
	</td>
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
		<font face=Arial size=1 color=#333333><b>&nbsp;TYPE</b>
	</td>
	<td>
	<select size=1 name=account_type style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select * from account_type where account_type not in ('external_user','service_account') order by account_type "; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value=$row[0]>$row[1]</option>";
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
<br>

