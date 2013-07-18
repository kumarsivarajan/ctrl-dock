<?include("config.php");?>
<?include("calendar.php");?>
<?
	$workflow=0;
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
		<b><font face="Arial" color="#CC0000" size="2">Leave Credit History: <?=$first_name?> <?=$last_name;?>
		<br>
		<font color=black face='Arial' size=1> Date of Joining : <? echo $joining_date; ?>
	</td>
	<td align=right>
		<a href="leave_app_1.php?account=<? echo $account;?>"><font face="Arial" color="#336699" size="1"><b>ADD LEAVE RECORD</b></font></a>
		&nbsp;
		<a href="leave.php?account=<? echo $account;?>"><font face="Arial" color="#336699" size="1"><b>LEAVE HISTORY</b></font></a>
		&nbsp;
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>

<?	
	
	$sql = "select * from leave_comp_off where username='$account' order by work_date DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>

<table border=1 width=98% cellspacing=0 cellpadding=4 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader width=70>Work Date</td>
		<td class=reportheader >Notes</td>
		<td class=reportheader width=80>Status</td>
		<td class=reportheader width=150>Approved By</td>
		<td class=reportheader width=70>On Date</td>
</tr>


<?
	$i=1;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
		<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata>&nbsp;<? echo date("d M Y",$row[2]); ?></font></td>

		<td class=reportdata>&nbsp;<? echo $row[3]; ?></font></td>
<?
		if($row[4]==0){$status="Pending Approval";}
		if($row[4]==1){$status="Approved";}
		if($row[4]==2){$status="Rejected";}
		if($row[4]==3){$status="Cancelled";}
?>
		<td class=reportdata>&nbsp;<? echo $status; ?></font></td>	

<?
		$sub_sql="select first_name,last_name from user_master where username='$row[6]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		if(mysql_num_rows($sub_result)==0){
		$approval_name="";
		$approval_date="";
		}else{
				$approval_name="$sub_row[0] $sub_row[1]";
				$approval_date=date("d M Y",$row[5]);
		}
?>
		<td class=reportdata>&nbsp;<? echo $approval_name; ?></font></td>
		<td class=reportdata>&nbsp;<? echo $approval_date; ?></font></td>
		</tr>
<?
		$i++;
	}
?>


<?
	if ($numrows==0){
?>
		<tr><td colspan=6 align=center><font face="Arial" size="2" color="#4D4D4D"><b>No applications for credit</font></b></td></tr>
<?
	}
?>
</table>