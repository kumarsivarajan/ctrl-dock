<?include("config.php");?>
<?include("ezq_leave_credit_header.php");?>

<? if ($FEATURE_LEAVE_CREDIT==1){?>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=2 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>My Pending Applications</b></td>
		<td colspan=3 bgcolor=#F5F5F5 align=right></td>
		
</tr>
<tr>
		<td class=reportheader width=90>Date of Work</td>		
		<td class=reportheader >Notes / Remarks</td>
		<td class=reportheader width=150>Status</td>		
</tr>


<?
	$sql = "select * from leave_comp_off where username='$employee' and status=0 order by work_date DESC";	
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
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $row[3]; ?></font></td>		
		
<?
		if($row[4]==0){$status="Pending Approval";}
		if($row[4]==1){$status="Approved";}
		if($row[4]==2){$status="Rejected";}		
		
?>
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $status; ?></font></td>		
		</tr>
<?
		$i++;
	}
	
?>


<?
	if ($numrows==0){
?>
		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No pending applications for credit</font></b></td></tr>
<?
	}
?>
</table>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td colspan=4 height=20 bgcolor=#F5F5F5 align=left>&nbsp;<font face=Arial size=2><b>Credit Applications pending my actions</b></td>		
</tr>
<tr>
		<td class=reportheader >Staff Name</td>
		<td class=reportheader width=90>Date of Work</td>		
		<td class=reportheader >Notes / Remarks</td>
		<td class=reportheader width=100>Action</td>
</tr>


<?
	$sql = "select * from leave_comp_off where status=0 and username in (SELECT username FROM user_organization WHERE direct_report_to='$employee' OR dot_report_to='$employee')";	
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
		<td class=ezqreportdata>&nbsp;&nbsp;<? echo $row[3]; ?></font></td>
		<td class=ezqreportdata align=center>&nbsp;<a href='co_action_1.php?action=1&no=<?echo $row[0];?>&staff=<?echo $row[1];?>'><b><font color=green>Approve</a> | <a href='co_action_1.php?action=2&no=<?echo $row[0];?>&staff=<?echo $row[1];?>'><font color=red>Reject</a>&nbsp;</font><b></td>
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
}
?>
</table>