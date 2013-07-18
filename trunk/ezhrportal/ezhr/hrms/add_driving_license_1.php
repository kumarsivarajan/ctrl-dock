<?php 
include("config.php"); 
include("calendar.php"); 

$account=$_REQUEST["account"];

$sql = "select * from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
if ($row[14]=="Obsolete"){
	echo "<center><font face=Arial size=2 color=#003366>The account <b>$row[0]</b> is obsolete.<br><br>Obsolete accounts cannot be updated</font></b>";
} else {

?>

<form method=POST action=add_driving_license_2.php>

<table border=0 cellpadding=0 cellspacing=2 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Add Driving License Details</b></td></tr>
<tr>
	<td class=tdformlabel>License No</td>
	<td align=right><input name="license_no"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Date of Issue</td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=license_issue_date id="license_issue_date" readonly onclick="fPopCalendar('license_issue_date')"></td>
</tr>
<tr>
	<td class=tdformlabel>Valid Till</td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=license_valid_till id="license_valid_till" readonly onclick="fPopCalendar('license_valid_till')"></td>
</tr>
<tr>
	<td class=tdformlabel>Vehicle Category</td>
	<td align=right>
	<select size="1" name="category" style="font-size: 8pt; font-family: Arial">
		<option value="2 Wheeler">2 Wheeler</option>
		<option value="4 Wheeler">4 Wheeler</option>
		<option value="2 and 4 Wheeler">2 and 4 Wheeler</option>
	</select>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add License Information" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
<? } ?>
