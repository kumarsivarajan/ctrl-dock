<?php 
include("config.php"); 
include("calendar.php"); 

$account=$_REQUEST["account"];

$sql = "select * from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$account_status=$row[14];

?>
<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>

<form method=POST action=add_work_experience_2.php>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2 align=center><font face=Arial size=2 color=White><b>&nbsp;Add Work Experience</b></td></tr>
<tr>
	<td class=tdformlabel>Organization</td>
	<td align=right><input name="organization"  size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>From Date</td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
</tr>

<tr>
	<td class=tdformlabel>To Date</td>
	<td  align=right><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Work Experience" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

