<?include("config.php");?>
<?include("ezq_expense_header.php");?>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=8 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>My Expense Reports</b></td>
</tr>
<tr>		
		<td class=reportheader width=60>Report No.</td>
		<td class=reportheader >Description</td>
		<td class=reportheader width=80>Total</td>
		<td class=reportheader width=140>Status</td>
		<td class=reportheader width=40>Info</td>
		<td class=reportheader width=40>Edit</td>
		<td class=reportheader width=40>Del</td>
		<td class=reportheader width=40>Submit</td>
		
</tr>


<?
	$sql = "select * from expense_report where username='$employee' and (status!='REJECTED' and status!='CLEARED') order by expense_id";	
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>


<?
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
		<td class=ezqreportdata style="text-align:center"><a target=_blank href='print_expense.php?expense_id=<?echo $row[0];?>'><img src=images/comments.gif border=0></img></a><b></td>
<?		if($row[3]=="DRAFT"){?>
		<td class=ezqreportdata style="text-align:center"><a href='edit_expense.php?expense_id=<?echo $row[0];?>'><img src=images/edit.gif border=0></img></a><b></td>
		<td class=ezqreportdata style="text-align:center"><a href='delete_expense_1.php?expense_id=<?echo $row[0];?>'><img src=images/delete.gif border=0></img></a><b></td>
		<td class=ezqreportdata style="text-align:center"><a href='submit_expense_1.php?expense_id=<?echo $row[0];?>'><img src=images/leave_submit.gif border=0></img></a><b></td>
		
<?		}else{	?>
			<td class=ezqreportdata style="text-align:center">&nbsp;</td>
			<td class=ezqreportdata style="text-align:center">&nbsp;</td>
			<td class=ezqreportdata style="text-align:center">&nbsp;</td>
<?		}	?>
		
		</tr>
<?
		$i++;
		}
	if ($numrows==0){
?>
		<tr><td colspan=7 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No expense reports created</font></b></td></tr>
<?
	}
?>
</table>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=5 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>Expense reports pending my actions</b></td>
</tr>
<tr>
		<td class=reportheader width=200>Staff Name</td>				
		<td class=reportheader >Description</td>
		<td class=reportheader width=80>Total</td>		
		<td class=reportheader width=40>Info</td>
		<td class=reportheader width=100>Action</td>
</tr>


<?
	$sql = "SELECT expense_id,expense_desc,username FROM expense_report WHERE STATUS='PENDING APPROVAL' AND username IN (SELECT username FROM user_organization WHERE direct_report_to='$employee' OR dot_report_to='$employee')";	
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>


<?
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
		$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row=mysql_fetch_row($sub_result);
		$grand_total=round($sub_row[0],2);

?>
		<tr bgcolor=<?echo $row_color; ?>>
<?
		$sub_sql="select first_name,last_name from user_master where username='$row[2]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=ezqreportdata>&nbsp;<? echo "$sub_row[0] $sub_row[1]"; ?></font></td>
		<td class=ezqreportdata>&nbsp;<? echo "$row[1]"; ?></font></td>
		<td class=ezqreportdata style="text-align:right">&nbsp;<? echo $CURRENCY; ?> <? echo $grand_total; ?>&nbsp;</font></td>
		<td class=ezqreportdata style="text-align:center"><a target=_blank href='print_expense.php?expense_id=<?echo $row[0];?>'><img src=images/comments.gif border=0></img></a><b></td>
		<td class=ezqreportdata align=center>&nbsp;<a href='expense_action_1.php?expense_id=<?echo $row[0];?>&action=APPROVED'><b><font color=green>Approve</a> | <a href='expense_action_1.php?expense_id=<?echo $row[0];?>&action=REJECTED'><font color=red>Reject</a>&nbsp;</font><b></td>
		</tr>
<?
		$i++;
		}
	
	if ($numrows==0){
?>
		<tr><td colspan=5 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No pending applications requiring your action</font></b></td></tr>
<?
	}
?>
</table>
