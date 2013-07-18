<?include("config.php");?>
<?$ACTION=" : History" ?>
<?include("ezq_leave_credit_header.php");?>
<center>
<br><br>
<?
	$workflow=0;
	$sql = "select * from leave_comp_off where username='$employee' order by work_date DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>

<table border=1 width=98% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
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
		<td class=ezqreportdata>&nbsp;<? echo date("d M Y",$row[2]); ?></font></td>

		<td class=ezqreportdata>&nbsp;<? echo $row[3]; ?></font></td>
<?
		if($row[4]==0){$status="Pending Approval";}
		if($row[4]==1){$status="Approved";}
		if($row[4]==2){$status="Rejected";}
		if($row[4]==3){$status="Cancelled";}
?>
		<td class=ezqreportdata>&nbsp;<? echo $status; ?></font></td>	

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
		<td class=ezqreportdata>&nbsp;<? echo $approval_name; ?></font></td>
		<td class=ezqreportdata>&nbsp;<? echo $approval_date; ?></font></td>
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