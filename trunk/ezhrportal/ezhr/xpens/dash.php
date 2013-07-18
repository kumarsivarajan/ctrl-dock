<?
include_once("header.php");


$grand_total=0;
$sql = "SELECT expense_id,expense_desc,username FROM expense_report WHERE STATUS='PENDING APPROVAL' order by expense_id";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);
while ($row = mysql_fetch_row($result)) {
	$total=0;
	$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$total=round($sub_row[0],0);
	$grand_total=$grand_total+$total;
}
$pa=$grand_total;
$pa_reports=$numrows;


$grand_total=0;
$sql = "SELECT expense_id,expense_desc,username FROM expense_report WHERE STATUS='PENDING VERIFICATION' order by expense_id";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);
while ($row = mysql_fetch_row($result)) {
	$total=0;
	$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$total=round($sub_row[0],0);
	$grand_total=$grand_total+$total;
}
$pv=$grand_total;
$pv_reports=$numrows;

$grand_total=0;
$sql = "SELECT expense_id,expense_desc,username FROM expense_report WHERE STATUS='PENDING CLEARANCE' order by expense_id";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);
while ($row = mysql_fetch_row($result)) {
	$total=0;
	$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$total=round($sub_row[0],0);
	$grand_total=$grand_total+$total;
}
$pc=$grand_total;
$pc_reports=$numrows;

?>
<table class=reporttable border=0 width=100% height=180 cellspacing=1 cellpadding=5>
	<tr>
		<td bgcolor=#666666 align=center width=30%><font face=Arial size=1 color=white>EXPENSES<br>PENDING APPROVAL<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$pa_reports;?></td>
		<td bgcolor=#666666 align=center width=30%><font face=Arial size=1 color=white>AMOUNT<br>PENDING APPROVAL<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$CURRENCY;?> <?=$pa;?></td>
		<td bgcolor=#993333 align=center width=40% rowspan=3><font face=Arial size=1 color=white>TOTAL EXPENSES<br>PENDING RE-IMBURSEMENT<br><br><br><font face=Arial size=5 color=#BFDFFF><b><?=$CURRENCY;?> <?=$pv+$pc+$pa;?></td>
	</tr>
	<tr>
		<td bgcolor=#558080 align=center width=30%><font face=Arial size=1 color=white>EXPENSES<br>PENDING VERIFICATION<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$pv_reports;?></td>
		<td bgcolor=#558080 align=center width=30%><font face=Arial size=1 color=white>AMOUNT<br>PENDING VERIFICATION<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$CURRENCY;?> <?=$pv;?></td>
	</tr>
	<tr>
		<td bgcolor=#4E4E74 align=center width=30%><font face=Arial size=1 color=white>EXPENSES<br>PENDING CLEARANCE<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$pc_reports;?></td>
		<td bgcolor=#4E4E74 align=center width=30%><font face=Arial size=1 color=white>AMOUNT<br>PENDING CLEARANCE<br><br><font face=Arial size=5 color=#BFDFFF><b><?=$CURRENCY;?> <?=$pc;?></td>
	</tr>
</table>