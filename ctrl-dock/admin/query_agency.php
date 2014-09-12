<?php
include("config.php"); 
if (!check_feature(38)){feature_error();exit;}
$SELECTED="VENDORS / CUSTOMERS";
include("header.php");
?>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#C0C0C0>

<tr>

<form method="POST" action="agency_list.php">
	<td align=right><font face=Arial size=1 color=white><b>AGENCY</b></td>
	<td><input type=text name=name size=60 style="font-family: Arial; font-size: 8pt;"></td>

	<td align=right><font face=Arial size=1 color=white><b>TYPE</b></td>
	<td>
	<select size=1 name=type style="font-size: 8pt; font-family: Arial">
	<?php
		echo "<option value=%></option>";
	        $sql = "select * from agency_type order by agency_type"; 	
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
        		echo "<option value=$row[0]>$row[0]</option>";
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

