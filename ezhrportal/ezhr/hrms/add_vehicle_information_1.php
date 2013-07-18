<?php 
include("config.php"); 
include("callcalendar.html"); 

$account=$_REQUEST["account"];

$sql = "select * from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[14]=="Obsolete"){
	echo "<center><font face=Arial size=2 color=#003366>The account <b>$row[0]</b> is obsolete.<br><br>Obsolete accounts cannot be updated</font></b>";
} else {

?>

<form method=POST action=add_vehicle_information_2.php>

<table border=0 cellpadding=0 cellspacing=2 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Add Vehicle</b></td></tr>
<tr>
	<td class=tdformlabel>Vehicle Type</font></b></td>
	<td align=right>
	<select size="1" name="vehicle_type" style="font-size: 8pt; font-family: Arial">
		<option value="2 Wheeler">2 Wheeler</option>
		<option value="4 Wheeler">4 Wheeler</option>
	</select>
</tr>

<tr>
	<td class=tdformlabel>Make</font></b></td>
	<td align=right><input name="vehicle_make"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>Registration No.</font></b></td>
	<td align=right><input name="vehicle_no"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Vehicle" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
<? } ?>
