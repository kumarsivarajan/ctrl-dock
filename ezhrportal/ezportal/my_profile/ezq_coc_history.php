<?include("config.php"); ?>
<?$ACTION=" : Approval History" ?>
<?include("ezq_leave_credit_header.php");?>
<center>
<br><br>
<?
	
	$workflow=0;
	
	$sql = "select * from leave_comp_off where status!=0 and username in (SELECT username FROM user_organization WHERE direct_report_to='$employee' OR dot_report_to='$employee') order by work_date DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
	if ($numrows>0){
		$workflow=1;
	
?>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
	<tr>
		<td class=reportheader >Staff Name</td>
		<td class=reportheader colspan=2>Work Date</td>		
		<td class=reportheader width=70>Status</td>
		<td colspan=2 class=reportheader>Approved By</td>
		<td class=reportheader width=70>On Date</td>
	</tr>
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
		<td class=ezqreportdata>&nbsp;<? echo "$sub_row[0] $sub_row[1]"; ?></font></td>		
		<td class=ezqreportdata>&nbsp;<? echo date("d M Y",$row[2]); ?></font></td>
		<td class=ezqreportdata title='Note : <? echo $row[3]; ?>' style='text-align:center;' width=20><img src=images/comments.gif></font></td>
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
		<td class=ezqreportdata title='Comments : <? echo $row[7]; ?>'  style='text-align:center;' width=20><img src=images/comments.gif></font></td>
		<td class=ezqreportdata>&nbsp;<? echo $approval_date; ?></font></td>
		</tr>
<?
		$i++;
		}
	}
?>
</table>

<?
	if ($workflow==0){
?>
		<br><font face="Arial" size="2" color="#4D4D4D"><b>No records in History</font></b>
<?
	}
?>