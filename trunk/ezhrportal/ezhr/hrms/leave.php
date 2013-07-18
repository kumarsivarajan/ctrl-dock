<?
include("config.php"); 
if (!check_feature(10)){feature_error();exit;}
include("calendar.php");

	$today=mktime();
	$comp_off_expiry=$today-($compensatory_leave_validity*86400);


	$account=$_REQUEST["account"];
	$sql = "select first_name,last_name,account_status from user_master where username='$account'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);

	$first_name		=$row[0];
	$last_name		=$row[1];
	$account_status	=$row[2];
	

	// Fetch joining date of the employee
	$sql = "select date_of_joining from user_personal_information where username='$account'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$joining_date=date("d M Y",$row[0]);
	
?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Leave History: <?=$first_name?> <?=$last_name;?>
		<br>
		<font color=black face='Arial' size=1> Date of Joining : <? echo $joining_date; ?>
	</td>
	<td align=right>
		<a href="leave_app_1.php?account=<? echo $account;?>"><font face="Arial" color="#336699" size="1"><b>ADD LEAVE RECORD</b></font></a>
		&nbsp;
		<a href="leave_credit_history.php?account=<? echo $account;?>"><font face="Arial" color="#336699" size="1"><b>LEAVE CREDIT HISTORY</b></font></a>
		&nbsp;
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>



<?

	// FETCH LEAVE RECORDS AND LIST

	$sql = "select * from leave_form where username='$account' and leave_status!=3 order by from_date DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	$workflow=1;
	$al=0;
	$cl=0;
	$col=0;
	$lop=0;
	if ($numrows>0){
?>

	<table border=1 width=100% cellspacing=0 cellpadding=4 style="border-collapse: collapse" bordercolor="#E5E5E5">
	<tr>
                <td class=reportheader width=150><b>Staff Name</td>
                <td class=reportheader width=80><b>From Date</td>
                <td class=reportheader width=80><b>To Date</td>
                <td class=reportheader width=90><b>Leave Type</td>
                <td class=reportheader ><b>Reason</td>
                <td class=reportheader width=90><b>Status</td>
                <td class=reportheader width=150><b>Approved By</td>
                <td class=reportheader width=80><b>On Date</td>
                <td class=reportheader><b>Edit</td>
	</tr>
<?
	
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
	
		$leave_days=(($row[3]-$row[2])/86400)+1;
	
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
		<tr bgcolor=<?echo $row_color; ?>>
<?
		$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
?>
		<td class=reportdata><? echo "$sub_row[0] $sub_row[1]"; ?></td>
		<td class=reportdata><? echo date("d M Y",$row[2]); ?></td>
		<td class=reportdata><? echo date("d M Y",$row[3]); ?></td>	
<?

		$sub_sql="select leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		if($row[5]==1 && $row[6]=='1'){$al=$al+$leave_days;}
		if($row[5]==2 && $row[2]>=$fy_start && $row[6]=='1'){$cl=$cl+$leave_days;}
		if($row[5]==3 && $row[6]=='1'){$lop=$lop+$leave_days;}
		if($row[5]==4 && $row[6]=='1'){$col=$col+$leave_days;}
?>
		<td class=reportdata><? echo $sub_row[0]; ?></font></td>
		<td class=reportdata><? echo $row[4]; ?></font></td>
<?
		if($row[6]==0){$status="Pending Approval";$status_color="#FF9900";}
		if($row[6]==1){$status="Approved";$status_color="#009933";}
		if($row[6]==2){$status="Rejected";$status_color="#CC0000";}
		if($row[6]==3){$status="Cancelled";$status_color="#009933";}
?>
		<td class=reportdata><? echo $status; ?></font></td>
		
<?
		$sub_sql="select first_name,last_name from user_master where username='$row[7]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$fullname="$sub_row[0] $sub_row[1]";
		$approval_date=date("d M Y",$row[8]);
		if($row[6]==0){$fullname="";$approval_date="";}
		
?>
		<td class=reportdata><? echo $fullname; ?></font></td>
		<td class=reportdata><? echo $approval_date; ?></font></td>
		<td class=reportdata style='text-align:center'><a href="leave_edit_1.php?account=<?echo $account;?>&leave_no=<? echo $row[0]; ?>"><img border=0 src="images/edit.gif"></a></font></td>
		</tr>
<?
		$i++;
	}
	echo "</table>";
}else{
	echo "<br><font face=Arial size=2 color=#4D4D4D><b>No Leave Records</font></b>";
}
	

?>
	<br>
	<table border=0 width=100% cellspacing=0 cellpadding=4>
		<tr><td valign=top width=33%>
			<b><font face="Arial" color="#CC0000" size="2">Leave Summary
		</td></tr>
	</table>
		
	<table border=1 width=100% height=120 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
	
	<tr>
		<td bgcolor=#EDEDE4 align=left width=270><font color=#336699  face='Arial' size=2><b>Leave Type</b></td>
		<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Total Credit</font></td>
		<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Leave Availed</font></td>
		<td bgcolor=#EDEDE4 align=center><font color=#003366 face=Arial size=2><b>Leave Balance</font></td>
	</tr>
	<?
	$leave_summary=leave_summary($account);

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
<?	
?>
