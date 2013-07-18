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

<form method=POST action=add_visa_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Update Visa Records</b></td></tr>
<tr>
	<td class=tdformlabel>Country</font></b></td>
	<td align=right><input name="country"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Type of Visa</font></b></td>
	<td align=right><input name="visa_type"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Valid Till</font></b></td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=valid_till id="valid_till" readonly onclick="fPopCalendar('valid_till')"></td>

</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
<? } ?>
