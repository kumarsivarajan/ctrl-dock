<?php 
include_once("config.php");

$record_index			=$_REQUEST["record_index"];

$ui_from_date			=$_REQUEST["ui_from_date"];
$ui_to_date				=$_REQUEST["ui_to_date"];

$account				=$_REQUEST["account"];


$sql="select c.name,b.description,a.start_date,a.end_date,a.activity,d.first_name,d.last_name,a.record_index from timesheet a,timesheet_context b,agency c,user_master d";
$sql.=" where a.context_id=b.context_id and a.agency_index=c.agency_index and a.username=d.username";
$sql.=" and record_index='$record_index'";
$result = mysql_query($sql);	

$row=mysql_fetch_row($result);
			$agency		=$row[0];
			$context	=$row[1];
			$start_date	=date("d-m-Y H:i","$row[2]");
			$end_date	=date("d-m-Y H:i","$row[3]");
			$hours=round((($row[3]-$row[2])/3600),1);
			$total_hours=$total_hours+$hours;
			$activity	=nl2br($row[4]);
			$name		=$row[5]. " " .$row[6];
			$record_index=$row[7];
	
?>
<h2>Confirm Deletion</h2>
<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
	<tr>
		<td class=reportheader width=180>Staff</td>
		<td class=reportheader width=90>Start Date / Time</td>
		<td class=reportheader width=90>End Date / Time</td>
		<td class=reportheader width=50>Hours</td>
		<td class=reportheader width=90>Context</td>
		<td class=reportheader width=150>Agency</td>
		<td class=reportheader colspan=2>Activity</td>
	</tr>

		<tr>
		<td class=reportdata><?=$name;?></td>
		<td class=reportdata style='text-align:center;'><?=$start_date;?></td>
		<td class=reportdata style='text-align:center;'><?=$end_date;?></td>
		<td class=reportdata style='text-align:center;'><?=$hours;?></td>
		<td class=reportdata style='text-align:center;'><?=$context;?></td>
		<td class=reportdata><?=$agency;?></td>
		<td class=reportdata><?=$activity;?></td>
		</tr>
</table>



<form method=POST action="del_timesheet_confirm.php">
	<input type=hidden name=record_index value="<?=$record_index;?>">
	<input type=hidden name=ui_from_date value="<?=$ui_from_date;?>">
	<input type=hidden name=ui_to_date value="<?=$ui_to_date;?>">
	<input type=hidden name=account value="<?=$account;?>">
<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
	<tr>
		<td class=reportdata><b>Reason for Deletion</b></td>
		<td align=right><textarea rows=4 name="comments" cols="100" style="font-size: 8pt; font-family: Arial"></textarea></td>
	</tr>
	<tr>
	<td colspan=2 align="center">
		<input type=submit value="Confirm Deletion" name="Submit" style="font-size: 8pt; font-family: Arial">
		<INPUT TYPE="button" VALUE="Cancel" onClick="history.go(-1);return true;" style="font-size: 8pt; font-family: Arial">
	</td>
	</tr>
</table>
</form>
		
