<?php 

include("config.php");
include("calendar.php");
include("date_to_int.php");

$from_date=$_REQUEST['from_date'];
$ui_from_date	=$from_date;
$from_date=search_date_to_int($from_date,0,0);

$to_date=$_REQUEST['to_date'];
$ui_to_date		=$to_date;
$to_date=search_date_to_int($to_date,23,59);

$search_end_date=date('d-m-Y');
$search_from_date=date('d-m-Y',mktime()-(86400*7));

$account=rtrim($_REQUEST['account']);

?>
<center>
<?include_once("header.php");?>
<table border=0 width=100% cellspacing=0 cellpadding=2>
<form method=POST action="index.php">
<tr bgcolor="#CCCCCC">
	<td><font face=Arial size=1><b>&nbsp;VIEW TIME SHEETS</td>

	<td align=right><font face=Arial size=1><b>STAFF</td>
	<td>
	             <select size=1 name=account style="font-size: 8pt; font-family: Arial">
                        <?php
								echo "<option value='%'>ALL</option>";
                        		$sub_sql = "select username,first_name,last_name from user_master where account_status='Active' order by first_name";
								$sub_result = mysql_query($sub_sql);														
								while ($sub_row = mysql_fetch_row($sub_result)){
										echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
								}
                         ?>
                </select>
	</td>
	
	<td align=right><font face=Arial size=1><b>FROM DATE : </td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" value='<?=$search_from_date;?>' readonly onclick="fPopCalendar('from_date')"></td>
	
	<td align=right><font face=Arial size=1><b>TO DATE : </td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" value='<?=$search_end_date;?>' readonly onclick="fPopCalendar('to_date')"></td>
	
	<td align="center">
	<input type=submit value="GO >>" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

<?
	
	$sql="select c.name,b.description,a.start_date,a.end_date,a.activity,d.first_name,d.last_name,a.record_index,e.project_description from timesheet a,timesheet_context b,agency c,user_master d,timesheet_project e";
	$sql.=" where a.context_id=b.context_id and a.agency_index=c.agency_index and a.username=d.username and a.project_index=e.project_index";
	$sql.=" and a.start_date>='$from_date' and a.end_date<='$to_date'";
	if($account=="%"){
		$sql.=" and a.username like '$account%'";
	}else{
		$sql.=" and a.username='$account'";
	}
	$sql.=" order by a.start_date";
	$result = mysql_query($sql);	
	$record_count=mysql_num_rows($result);
	if ($record_count>0){
?>
		<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
		<tr>
			<td colspan=7 class=reportdata style='text-align:right;'><a href='staff_time_sheet_export.php?from_date=<?=$from_date?>&to_date=<?=$to_date?>&agency_index=<?=$agency_index;?>&account=<?=$account;?>&header_name=<?=$header_name;?>'>Export to Excel</a>
			</td>
		</tr>
		<tr>
			<td class=reportheader width=180>Staff</td>
			<td class=reportheader width=90>Start / End </td>
			<td class=reportheader width=20>Hrs</td>
			<td class=reportheader width=90>Context</td>
			<td class=reportheader width=150>Client</td>
			<td class=reportheader colspan=2 width=220>Activity</td>
		</tr>
<? 
		$row_color="#FFFFFF";
		$total_hours=0;
		while ($row=mysql_fetch_row($result)){
			$agency		=$row[0];
			$context	=$row[1];
			$start_date	=date("d-m-Y H:i","$row[2]");
			$end_date	=date("d-m-Y H:i","$row[3]");
			$hours=round((($row[3]-$row[2])/3600),1);
			$total_hours=$total_hours+$hours;
			$activity	=nl2br($row[4]);
			$name		=$row[5]. " " .$row[6];
			$record_index=$row[7];
			$project_description=$row[8];
?>		
			<tr>
			<td class=reportdata><?=$name;?></td>
			<td class=reportdata style='text-align:center;'><?=$start_date;?><br><?=$end_date;?></td>
			<td class=reportdata style='text-align:center;'><?=$hours;?></td>
			<td class=reportdata style='text-align:center;'><?=$context;?></td>
			<td class=reportdata><?=$agency;?><br><?=$project_description;?></td>
			<td class=reportdata><?=$activity;?></td>
			<td class=reportdata style='text-align:center'><a href="del_timesheet.php?record_index=<?=$record_index;?>&ui_from_date=<?=$ui_from_date;?>&ui_to_date=<?=$ui_to_date;?>&account=<?=$account;?>"><img border=0 src="images/delete.gif"></td>
<?
		}
?>
		<tr>
			<td class=reportheader colspan=3 style='text-align:right;'>TOTAL HRS&nbsp;</font></b></td>
			<td class=reportheader style='text-align:center;'><?=$total_hours;?>&nbsp;</font></b></td>
			<td class=reportheader colspan=4>&nbsp;</td>
		</tr>
</table>
<?
	}else{
	?>
		<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
		<tr>
			<td class=reportdata >No Records Found</font></b></td>
		</tr>
		</table>
	<?
	}
?>
