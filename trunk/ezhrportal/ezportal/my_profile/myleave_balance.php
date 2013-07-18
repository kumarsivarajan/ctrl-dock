<?
include("config.php");

?>
<table border=0 width=100% height=30 cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td bgcolor=#FF6600><font face=Arial size=2 color=white><b>Leave / Vacation</b></td>
</table>

<center>
<br>
<table border=0 width=100% cellspacing=0 cellpadding=4>
<tr><td valign=top width=33%>
<table border=1 width=100% height=120 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">

<tr>
	<td bgcolor=#EDEDE4 align=left width=270><font color=#336699  face='Arial' size=2><b>Leave Type</b></td>
	<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Total Credit</font></td>
	<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Leave Availed</font></td>
	<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Leave Balance</font></td>
</tr>
<?
$leave_summary=leave_summary($employee);

for ($i=0;$i<count($leave_summary);$i++){
	$leave_type	=$leave_summary[$i][1];
	$credit		=$leave_summary[$i][2];
	$availed	=$leave_summary[$i][3];
	$balance	=$leave_summary[$i][4];
	echo "<tr>";
	echo "<td bgcolor=#EDEDE4 align=left width=270><font color=#336699  face='Arial' size=2>$leave_type</td>";
	echo "<td align=center><font color=#003366 face=Arial size=2>$credit</font></td>";
	echo "<td align=center><font color=#003366 face=Arial size=2>$availed</font></td>";
	echo "<td align=center><font color=#003366 face=Arial size=2>$balance</font></td>";
	echo "</tr>";
}
?>
</table>
