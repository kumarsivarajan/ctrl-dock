<?include_once("search.php");?><?	$from_date	=$_REQUEST["from_date"];		$to_date	=$_REQUEST["to_date"];			$status		=$_REQUEST["status"];	$staff		=$_REQUEST["staff"];?><table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5"><tr>		<td class=reportheader width=80>Report ID</td>				<td class=reportheader width=100>Date</td>				<td class=reportheader width=150>Staff Name</td>		<td class=reportheader >Description</td>		<td class=reportheader width=80>Total</td>		<td class=reportheader width=80>Action</td>		<td class=reportheader width=40>Info</td>	</tr><?	$sql = "SELECT a.expense_id,a.expense_desc,a.username,action_date,action FROM expense_report a,expense_log b WHERE a.expense_id=b.expense_id AND b.action LIKE '%$status' and a.username like '%$staff'";	if(strlen($from_date)>0 && strlen($to_date)){		$from_date	=date_to_int($from_date);		$to_date	=date_to_int($to_date);		$sql.= " and action_date>=$from_date AND action_date<=$to_date";	}	$sql.= " ORDER BY expense_id DESC, action_date DESC";	$result = mysql_query($sql);	$numrows = mysql_num_rows($result);		$i=1;	$row_color="#FFFFFF";	while ($row = mysql_fetch_row($result)) {		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}		$sub_sql="SELECT SUM(total) FROM expense_report_info WHERE expense_id='$row[0]'";		$sub_result = mysql_query($sub_sql);		$sub_row=mysql_fetch_row($sub_result);		$grand_total=$sub_row[0];				$report_id=str_pad($row[0], 4, "0", STR_PAD_LEFT);		$report_id=$EXPENSE_PREFIX.$report_id;?>		<tr bgcolor=<?echo $row_color; ?>><?		$sub_sql="select first_name,last_name from user_master where username='$row[2]'";		$sub_result = mysql_query($sub_sql);		$sub_row = mysql_fetch_row($sub_result);?>		<td class=ezqreportdata style="text-align:center"><? echo "$report_id"; ?></font></td>		<td class=ezqreportdata style="text-align:center"><? echo date("d M Y h:i",$row[3]); ?></font></td>		<td class=ezqreportdata>&nbsp;<? echo "$sub_row[0] $sub_row[1]"; ?></font></td>		<td class=ezqreportdata>&nbsp;<? echo "$row[1]"; ?></font></td>		<td class=ezqreportdata style="text-align:right">&nbsp;<? echo $CURRENCY; ?> <? echo $grand_total; ?>&nbsp;</font></td>		<td class=ezqreportdata style="text-align:center">&nbsp;<? echo $row[4]; ?></font></td>		<td class=ezqreportdata style="text-align:center"><a target=_blank href='print_expense.php?expense_id=<?echo $row[0];?>'><img src=images/comments.gif border=0></img></a><b></td>				</tr><?		$i++;		}		if ($numrows==0){?>		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No records found.</font></b></td></tr><?	}?></table>