<?include("config.php");?>
<?$ACTION=" : History"?>
<?include("ezq_expense_header.php"); ?>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>		
		<td class=reportheader width=60>Report No.</td>
		<td class=reportheader >Description</td>
		<td class=reportheader width=80>Total</td>
		<td class=reportheader width=140>Status</td>
		<td class=reportheader width=40>Info</td>		
</tr>


<?
	$sql = "select * from expense_report where username='$employee' and (status='REJECTED' or status='CLEARED') order by expense_id DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}

		$report_id=str_pad($row[0], 4, "0", STR_PAD_LEFT);
		$report_id=$EXPENSE_PREFIX.$report_id;

		
		$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row=mysql_fetch_row($sub_result);
		$grand_total=$sub_row[0];
		
?>
		<tr bgcolor=<?echo $row_color; ?>>
		
		<td class=ezqreportdata style="text-align:center">&nbsp;<? echo $report_id; ?></font></td>		
		<td class=ezqreportdata>&nbsp;<? echo $row[1]; ?></font></td>		
		<td class=ezqreportdata style="text-align:right">&nbsp;<? echo $CURRENCY; ?> <? echo $grand_total; ?>&nbsp;</font></td>
		<td class=ezqreportdata style="text-align:center">&nbsp;<? echo $row[3]; ?></font></td>
		<td class=ezqreportdata style="text-align:center"><a href='print_expense.php?expense_id=<?echo $row[0];?>' target=_blank><img src=images/comments.gif border=0></img></a><b></td>
		</tr>
<?
		$i++;
		}
?>


<?
	if ($numrows==0){
?>
		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No expense reports created</font></b></td></tr>
<?
	}
?>
</table>