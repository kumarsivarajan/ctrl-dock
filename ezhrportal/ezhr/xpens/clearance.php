<?include_once("header.php");?><table border=1 width=100% cellspacing=0 cellpadding=4 style="border-collapse: collapse" bordercolor="#E5E5E5"><tr>		<td class=reportheader width=80>Report ID</td>				<td class=reportheader width=150>Staff Name</td>				<td class=reportheader >Description</td>		<td class=reportheader width=80>Total</td>				<td class=reportheader width=40>Info</td>		<td class=reportheader width=100>Action</td></tr><?	$sql = "SELECT expense_id,expense_desc,username FROM expense_report WHERE STATUS='PENDING CLEARANCE' order by expense_id";	$result = mysql_query($sql);	$numrows = mysql_num_rows($result);		$i=1;	$row_color="#FFFFFF";	while ($row = mysql_fetch_row($result)) {		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}		$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";		$sub_result = mysql_query($sub_sql);		$sub_row=mysql_fetch_row($sub_result);		$grand_total=round($sub_row[0],2);				$report_id=str_pad($row[0], 4, "0", STR_PAD_LEFT);		$report_id=$EXPENSE_PREFIX.$report_id;?>		<tr bgcolor=<?echo $row_color; ?>><?		$sub_sql="select first_name,last_name from user_master where username='$row[2]'";		$sub_result = mysql_query($sub_sql);		$sub_row = mysql_fetch_row($sub_result);?>		<td class=reportdata style="text-align:center">&nbsp;<? echo "$report_id"; ?></font></td>		<td class=reportdata>&nbsp;<? echo "$sub_row[0] $sub_row[1]"; ?></font></td>		<td class=reportdata>&nbsp;<? echo "$row[1]"; ?></font></td>		<td class=reportdata style="text-align:right">&nbsp;<? echo $CURRENCY; ?> <? echo $grand_total; ?>&nbsp;</font></td>		<td class=reportdata style="text-align:center"><a target=_blank href='print_expense.php?expense_id=<?echo $row[0];?>'><img src=images/comments.gif border=0></img></a><b></td>		<td class=reportdata style="text-align:center">&nbsp;<a href='clear_1.php?expense_id=<?echo $row[0];?>&action=CLEARED'><b><font color=green>Clear</a> | <a href='clear_1.php?expense_id=<?echo $row[0];?>&action=REJECTED'><font color=red>Reject</a>&nbsp;</font><b></td>		</tr><?		$i++;		}		if ($numrows==0){?>		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No pending applications requiring clearance</font></b></td></tr><?	}?></table>