<?php 
include("config.php"); 
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
<form method=POST action=add_award_2.php>

<table border=0 cellpadding=0 cellspacing=2 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Add a Record</b></td></tr>
<tr>
	<td class=tdformlabel>Institution / Organization</td>
	<td align=right><input name="organization"  size="60" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Brief Description of the Award</td>
	<td align=right><textarea rows=4 name="award" cols="60" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>

<input name="account" size=40 type=hidden value="<? echo $account; ?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Award Details" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

