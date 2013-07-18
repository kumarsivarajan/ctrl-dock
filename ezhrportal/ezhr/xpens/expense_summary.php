<?include_once("../auth.php");?>
<?include_once("../include/css/default.css");?>

<?
	if(!isset($expense_id)){
		$expense_id=$_REQUEST["expense_id"];
	}
	$sql = "select a.expense_desc,b.first_name,b.last_name,b.staff_number from expense_report a, user_master b where expense_id='$expense_id' and a.username=b.username";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	
	$expense_label=$row[0];
	$staff_name=$row[1]." ".$row[2];
	$staff_no=$row[3];	

	$sql = "select action_date from expense_log where expense_id='$expense_id' order by log_id desc limit 1";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);	
	$expense_date=date("d M Y",$row[0]);
	
	$report_id=str_pad($expense_id, 4, "0", STR_PAD_LEFT);
	$report_id=$EXPENSE_PREFIX.$report_id;
	
?>
<center>
<table border=0 cellpadding=2 cellspacing=1 width=98%>
<tr>
	<td bgcolor=#AAAAAA width=100><font color=white face=Arial size=2><b>&nbsp;Report ID</font></b></td>	
	<td bgcolor=#AAAAAA width=290><font color=white face=Arial size=2><b>&nbsp;<?echo $report_id;?></font></b></td>	
	<td bgcolor=#AAAAAA width=100><font color=white face=Arial size=2><b>&nbsp;Description</font></b></td>	
	<td bgcolor=#AAAAAA width=290><font color=white face=Arial size=2><b>&nbsp;<?echo $expense_label;?></font></b></td>	
</tr>
<tr>
	<td bgcolor=#AAAAAA width=100><font color=white face=Arial size=2><b>&nbsp;Staff Name</font></b></td>
	<td bgcolor=#AAAAAA width=290><font color=white face=Arial size=2><b>&nbsp;<?echo $staff_name;?></font></b></td>	
	<td bgcolor=#AAAAAA width=100><font color=white face=Arial size=2><b>&nbsp;Staff No.</font></b></td>
	<td bgcolor=#AAAAAA width=290><font color=white face=Arial size=2><b>&nbsp;<?echo $staff_no;?></font></b></td>	
</tr>
</table>
<br>

<?
	$sql = "select a.expense_date,b.expense_type,a.bill_no,a.description,a.qty,a.unit_price,a.total,b.auth_reqd,a.entry_id from expense_report_info a,expense_type b where a.expense_type_id=b.expense_type_id and a.expense_id='$expense_id' order by a.expense_date";
	$result = mysql_query($sql);
?>
<table cellspacing=1 cellpadding=2 class='reporttable' width=98% >
<tr>
		<td class=reportheader width=40>Sl. No.</td>
		<td class=reportheader width=80>Date</td>
		<td class=reportheader width=200>Type</td>
		<td class=reportheader width=100>Bill No.</td>
		<td class=reportheader width=200>Description</td>
		<td class=reportheader width=40>Qty</td>
		<td class=reportheader width=80>Unit Price</td>
		<td class=reportheader width=80>Total</td>
		<?		if($expense_edit==1){?>
					<td class=reportheader width=40>Del</td>
<?		}	?>

</tr>
<?
	$i=1;
	$grand_total=0;
	$row_color="#FFFFFF";
	while ($row = mysql_fetch_row($result)) {
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
		<tr bgcolor=<?echo $row_color; ?>>
		
		<td class=reportdata style="text-align:center">&nbsp;<? echo $i; ?></font></td>		
		<td class=reportdata style="text-align:center">&nbsp;<? echo date("d M Y",$row[0]); ?></font></td>		
		<td class=reportdata>&nbsp;<? echo $row[1];if($row[7]==1){echo " * ";}?></font></td>
		<td class=reportdata style="text-align:center">&nbsp;<? echo $row[2]; ?></font></td>
		<td class=reportdata>&nbsp;<? echo $row[3]; ?></font></td>
		<td class=reportdata style="text-align:center">&nbsp;<? echo $row[4]; ?></font></td>
		<td class=reportdata style="text-align:right"><?echo $CURRENCY;?> <? echo $row[5]; ?>&nbsp;</font></td>
		<td class=reportdata style="text-align:right"><b><?echo $CURRENCY;?> <? echo $row[6]; ?>&nbsp;</b></font></td>
		
<?		if($expense_edit==1){?>
			<td class=reportdata style="text-align:center"><a href=expense_delete.php?entry_id=<?echo $row[8];?>&expense_id=<?echo $expense_id;?>><img src=images/delete.gif border=0></img></a></td>
<?		}	?>
		
		</tr>
<?
		$grand_total=$grand_total+$row[6];
		$i++;
}
?>
<tr>
		<td class=reportheader style="text-align:right" colspan=7>GRAND TOTAL&nbsp;</td>
		<td class=reportheader style="text-align:right"><?echo $CURRENCY;?> <?echo $grand_total;?>&nbsp;</td>
</tr>
<tr>
		<td colspan=8 class=reportdata style="text-align:left">&nbsp;* Amount is restricted to the authorization eligible for the staff.</td>
</tr>
</table>
<br>
<?

// Fetch Expense Logs
	$sql 	= "select action_date,action,first_name,last_name,action_comments from expense_log a,user_master b where a.action_by=b.username and expense_id='$expense_id' order by log_id ";	
	$result = mysql_query($sql);	
	$num_rows=mysql_num_rows($result);
	
	if($num_rows>0){
?>
	
	<table cellspacing=1 cellpadding=2 class='reporttable' width=98%>
	<tr>		
		<td colspan=4 bgcolor=#AAAAAA ><font color=white face=Arial size=2><b>&nbsp;APPROVAL LOG</font></b></td>	
	</tr>
	<tr>		
		<td class=reportheader width=80>Date</td>
		<td class=reportheader width=100>Action</td>
		<td class=reportheader width=100>Action By</td>
		<td class=reportheader >Comments</td>
	</tr>
<?
		$i=1;	
		$row_color="#FFFFFF";
		while ($row = mysql_fetch_row($result)) {
			if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
			<tr bgcolor=<?echo $row_color; ?>>	
			<td class=reportdata style="text-align:center">&nbsp;<? echo date("d M Y",$row[0]); ?></font></td>		
			<td class=reportdata>&nbsp;<? echo "$row[1]";?></font></td>
			<td class=reportdata>&nbsp;<? echo "$row[2] $row[3]";?></font></td>
			<td class=reportdata style="text-align:left">&nbsp;<? echo $row[4]; ?></font></td>		
			</tr>
<?
		$i++;
		}
	}
?>
	</table>