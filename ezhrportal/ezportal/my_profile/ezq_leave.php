<?include("config.php");?>
<?include("ezq_leave_header.php");?>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=6 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>My Pending Applications</b></td>

		
</tr>
<tr>
		<td class=reportheader width=90>From Date</td>
		<td class=reportheader width=90>To Date</td>
		<td class=reportheader width=120>Leave Type</td>
		<td class=reportheader >Reason</td>
		<td class=reportheader width=150>Status</td>
		<td class=reportheader width=100>Action</td>
</tr>


<?
	$sql = "select * from leave_form where username='$employee' and leave_status=0 order by from_date DESC";	
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>


<?
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
		<tr bgcolor=<?echo $row_color; ?>>
<?
		$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo date("d M Y",$row[2]); ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo date("d M Y",$row[3]); ?></font></td>
<?
		$sub_sql="select leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $sub_row[0]; ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $row[4]; ?></font></td>
		<?
		if($row[6]==0){$status="Pending Approval";}
		if($row[6]==1){$status="Approved";}
		if($row[6]==2){$status="Rejected";}
		if($row[6]==3){$status="Cancelled";}
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $status; ?></font></td>
		<td class=ezqreportdata align=center>&nbsp;<a href='leave_cancel.php?no=<?echo $row[0];?>'><b><font color=red>Cancel</a><b></td>
		</tr>
<?
		$i++;
		}
?>


<?
	if ($numrows==0){
?>
		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No leave applications</font></b></td></tr>
<?
	}
?>
</table>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=7 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>Leave Applications pending my actions</b></td>
</tr>
<tr>
		<td class=reportheader width=200>Staff Name</td>
		<td class=reportheader width=90>From Date</td>
		<td class=reportheader width=90>To Date</td>
		<td class=reportheader width=120>Leave Type</td>
		<td class=reportheader >Reason</td>
		<td class=reportheader width=90>Applied On</td>
		<td class=reportheader width=100>Action</td>
</tr>


<?
	$sql = "select * from leave_form where leave_status=0 and username in (SELECT username FROM user_organization WHERE direct_report_to='$employee' OR dot_report_to='$employee')";	
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>


<?
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
		<tr bgcolor=<?echo $row_color; ?>>
<?
		$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo "$sub_row[0] $sub_row[1]"; ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo date("d M Y",$row[2]); ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo date("d M Y",$row[3]); ?></font></td>
<?
		$sub_sql="select leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $sub_row[0]; ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $row[4]; ?></font></td>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo date("d M Y",$row[10]); ?></font></td>
		<td class=ezqreportdata align=center>&nbsp;<a href='leave_action_1.php?action=1&no=<?echo $row[0];?>&staff=<?echo $row[1];?>'><b><font color=green>Approve</a> | <a href='leave_action_1.php?action=2&no=<?echo $row[0];?>&staff=<?echo $row[1];?>'><font color=red>Reject</a>&nbsp;</font><b></td>
		</tr>
<?
		$i++;
		}
	
?>

<?
	if ($numrows==0){
?>
		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No pending applications requiring your action</font></b></td></tr>
<?
	}
?>
</table>