<?include("config.php"); ?>
<?include("calendar.php");?>
<?
$account=$_REQUEST["account"];
$leave_no=$_REQUEST["leave_no"];

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

$sql = "select * from leave_form where leave_no = '$leave_no'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

?>
<center>
<table border=0 cellpadding=3 cellspacing=0 width=50%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Leave Record: <?=$first_name?> <?=$last_name;?>
		<br>
		<font color=black face='Arial' size=1> Date of Joining : <? echo $joining_date; ?>
	</td>
	<td align=right>
		<a href="leave.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>


<form method=POST action=leave_edit_2.php>

<input type=hidden name=leave_no value=<?echo $row[0];?>>
<input type=hidden name=account value=<?echo $account;?>>
<table border=0 cellpadding=4 cellspacing=0 width=50%>

<tr>
	<td class=tdformlabel><b>Reason for Leave</font></b></td>
	<td align=right><font color=#4D4D4D face=Arial size=2><? echo "$row[4]";?></td></td>
</tr>
<tr>
	<td class=tdformlabel><b>Type of Leave</font></b></td>
	<td align=right>
			<select size=1 name=leave_category_id style="font-size: 8pt; font-family: Arial">
			<?
			    $sub_sql = "select leave_category_id,leave_category from leave_type where leave_category_id='$row[5]'";	
				$sub_result = mysql_query($sub_sql);
				$sub_row = mysql_fetch_row($sub_result);
		        echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
			?>

			<?
			    $sub_sql = "select leave_category_id,leave_category from leave_type";	
				$sub_result = mysql_query($sub_sql);
				while ($sub_row = mysql_fetch_row($sub_result)) {
		        		echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
				}
			?>
		</select>
	</td>
</tr>
<?
$diff	= $row[2] - $row[3];
$hd_selected="";
if ($diff==43200){$hd_selected="selected";}
?>

<tr>
	<td class=tdformlabel><b>Leave Start Date</font></b></td>
	<td  align=right><input value="<? if ($row[2]!="") echo date("d-m-Y",$row[2]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
</tr>

<tr>
	<td class=tdformlabel><b>Leave End Date</font></b></td>
	<td  align=right><input value="<? if ($row[3]!="") echo date("d-m-Y",$row[3]); ?>" style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
</tr>


<tr>
	<td class=tdformlabel><b>Half Day</font></b></td>
	<td align=right>
			<select size=0 name=half_day style="font-size: 8pt; font-family: Arial">
				<option value=0>No</option>
				<option value=1 <?=$hd_selected;?>>Yes</option>
			</select>
	</td>
</tr>

<?
		if($row[6]==0){$status="Pending Approval";}
		if($row[6]==1){$status="Approved";}
		if($row[6]==2){$status="Rejected";}
?>
<tr>
	<td class=tdformlabel><b>Leave Status</font></b></td>
	<td align=right>
	<?	if($row[6]==0){?>
		<select size=1 name=leave_status style="font-size: 8pt; font-family: Arial">
				<option value='<?echo $row[6];?>'><? echo $status;?></option>		
				<option value='1'>Approve</option>
				<option value='2'>Reject</option>
	<?	}	?>
	<?	if($row[6]==1 || $row[6]==2){?>
		<select size=1 name=leave_status style="font-size: 8pt; font-family: Arial">
				<option value='<?echo $row[6];?>'><? echo $status;?></option>	
				<option value='3'>Cancel</option>
	<?	}	?>
	
	<?	if($row[6]==3){?>
		<select size=1 name=leave_status style="font-size: 8pt; font-family: Arial">
				<option value='3'>Cancelled</option>		
	<?	}	?>
		</select>
	</td>
</tr>
<input type=hidden name=last_status value=<?=$row[6];?>>


<?
if($row[6]==1 || $row[6]==2){

		$sub_sql="select first_name,last_name from user_master where username='$row[7]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$fullname="$sub_row[0] $sub_row[1]";
		$approval_date=date("d M Y",$row[8]);
		if($row[6]==0){$fullname="";$approval_date="";}	
?>
<tr>
	<td class=tdformlabel><b><?echo "$status By";?></font></b></td>
	<td align=right><font color=#4D4D4D face=Arial size=2><b><? echo $fullname;?></td>
</tr>

<tr>
	<td class=tdformlabel><b><?echo "$status On";?></font></b></td>
	<td align=right><font color=#4D4D4D face=Arial size=2><b><? echo $approval_date;?></td>
</tr>
<?
	}
?>
<tr>
	<td class=tdformlabel><b>Comments</font></b></td>
	<td align=right><textarea rows="3" name="comments" cols="42" style="font-size: 8pt; font-family: Arial"><?echo $row[9];?></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit Application" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
