<?php 

include("config.php");
include("default.css");
include("../common/functions/date.php"); 
include("calendar.php");


$staff=$_REQUEST["staff"];

$from_date=$_REQUEST['from_date'];
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);

?>


<h2>Timesheet for user : <?=$staff?></h2>

<table border=1 width=700 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<form method=POST action=report_time_sheet.php?staff=<?=$staff?>>
<tr bgcolor="#CCCCCC">
	<td><font face=Arial size=2><b>Search Time Sheets</td>
	<td><font face=Arial size=2><b>From Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
	
	<td><font face=Arial size=2><b>To Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
	<td align="center">
	<input type=submit value="Search" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

<?
	$sql="select a.record_index,a.username,a.project_code,a.date,a.hours,a.task,b.project_code,b.project_description,c.agency_code from timesheet a, timesheet_project_code b,agency c  where username='$staff' and date>='$from_date' and date<='$to_date' and a.project_code=b.project_code and a.agency_index=c.agency_index order by date";
	$result = mysql_query($sql);	
	$record_count=mysql_num_rows($result);
	if ($record_count>0){
?>
		<table border=1 width=700 cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<tr>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Date</font></b></td>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Hours</font></b></td>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Client</font></b></td>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Project / Activity </font></b></td>
		</tr>
<? 
		$row_color="#FFFFFF";
		$total_hours=0;
		while ($row=mysql_fetch_row($result)){
			$actual_date=date("d-m-Y","$row[3]");
			$total_hours=$total_hours+$row[4];
			$row[5]=str_replace("\n","<br>","$row[5]");
?>		
		<tr bgcolor=<?echo $row_color; ?>>
		<td align=center width=80><font color=#003366 face=Arial size=2><? echo "$actual_date"; ?></font></td>
		<td align=center width=40><font color=#003366 face=Arial size=2><? echo "$row[4]"; ?></td>
		<td align=center width=100><font color=#003366 face=Arial size=2><? echo "$row[8]"; ?></td>
		<td align=left width=480><font color=#003366 face=Arial size=2><b><? echo "$row[7]"; ?></b><br><? echo "$row[5]"; ?></td>
		</tr>
<?
		}
		echo "<tr><td colspan=3><font color=#003366 face=Arial size=2><b>Total Hours Spent during this period : $total_hours Hours</b></td></tr>";
	}
?>
</table>