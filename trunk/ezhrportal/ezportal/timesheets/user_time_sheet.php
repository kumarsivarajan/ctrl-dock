<?php 

include("config.php");
include("default.css");
include("../common/functions/date.php"); 
include("calendar.php"); 


$employee=$_SERVER["PHP_AUTH_USER"];

$from_date=$_REQUEST['from_date'];
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);

?>
<center>
<h2>Timesheet for User : <?=$employee?></h2>

<form method=POST action=add_time_sheet.php>
<table border=0 cellpadding=0 cellspacing=0 width=700 bgcolor=#DDDDDD>
<tr><td bgcolor=#666633 colspan=2><font face=Arial size=1 color=White></td></tr>
<tr>
	<td><font color=#4D4D4D face=Arial size=2><b>&nbsp;Date & Hours of Work</font></b></td>
	 <td align=right>
	<input style="font-size: 8pt; font-family: Arial; width: 75px;" name=timesheet_date id="timesheet_date" readonly onclick="fPopCalendar('timesheet_date')">
    <select size=1 name=hours style="font-size: 8pt; font-family: Arial; width: 75px;">
               <option value=''></option>
                        <?php
								$i=0.5;						
								while ($i<=16){
	                                echo "<option value='$i'> $i</option>";
	                                $i=$i+0.5;
								}
                         ?>
     </select>
	 <br><br>
        </td>	
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>&nbsp;Client</font></b></td>
	        <td align=right>
                <select size=1 name=agency_index style="font-size: 8pt; font-family: Arial">
                        <?php
                        		$sub_sql = "select agency_index,agency_code,name from agency order by agency_code";
								$sub_result = mysql_query($sub_sql);														
								while ($sub_row = mysql_fetch_row($sub_result)){
										if(strlen($sub_row[1])==0){
											$label=$sub_row[2];
										}else{
											$label=$sub_row[1];
										}
										echo "<option value='$sub_row[0]'>$label</option>";
								}
                         ?>
                </select>
        </td>
</tr>
<tr>
	<td colspan=2 align=right><font color=#CC0000 face=Arial size=1><b>If the activity is internal to the company, then choose 'INTERNAL' from the list.</font></a></b><br>&nbsp;</td>
	</td>
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>&nbsp;Activity</font></b></td>
	        <td align=right>
                <select size=1 name=project_code style="font-size: 8pt; font-family: Arial">
               <option value=''></option>
                        <?php
                        		$sub_sql = "select * from timesheet_project_code order by project_description";
								$sub_result = mysql_query($sub_sql);														
								while ($sub_row = mysql_fetch_row($sub_result)){
	                                echo "<option value='$sub_row[0]'>$sub_row[1]</option>";
								}
                         ?>
                </select>
        </td>
</tr>
<tr>
	<td colspan=2 align=right><a href=Task_Activity_Information.xls target=_blank><font color=blue  face=Arial size=1><b>Task / Activity Information</font></a></b><br>&nbsp;</td>
	</td>
</tr>
<tr>
	<td><font color=#4D4D4D  face=Arial size=2><b>&nbsp;Details</font></b></td>
	<td align=right><textarea rows="10" name="activity_details" cols="80" style="font-size: 8pt; font-family: Arial"></textarea></td>
</tr>

<tr><td bgcolor=#666633 colspan=2><font face=Arial size=1 color=White></td></tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Submit Timesheet" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
<br>
<font face=Verdana size=1 color=#CC0000>Please ensure that you have verified the details you are submitting. Once entered, the time sheet entries cannot be changed.</font>
<br><br>
<br>


<table border=1 width=700 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<form method=POST action=user_time_sheet.php>
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
	$sql="select a.record_index,a.username,a.project_code,a.date,a.hours,a.task,b.project_code,b.project_description,c.agency_code from timesheet a, timesheet_project_code b,agency c   where username='$employee' and date>='$from_date' and date<='$to_date' and a.project_code=b.project_code and a.agency_index=c.agency_index order by date";
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