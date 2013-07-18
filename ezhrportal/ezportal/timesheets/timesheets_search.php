<?

include("config.php");
include("default.css");
include("../common/functions/date.php"); 
include("calendar.php");


$from_date=$_REQUEST['from_date'];
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);

$agency_index=$_REQUEST['agency_index'];
$project_code=$_REQUEST['project_code'];
$username=$_REQUEST['username'];

$employee=$_SERVER["PHP_AUTH_USER"];
$list=array();

?>


<b><font face="Arial" color="#FF6600" size="2">Search Timesheets</font></b>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<form method=POST action=timesheets_search.php>
<tr bgcolor="#CCCCCC">
	<td><font face=Verdana size=1><b>Staff </td>
	<td>

        <select size=1 name=username style="font-size: 8pt; font-family: Arial">
		<option value=''></option>
            <?php
               		$sub_sql = "SELECT b.username,a.first_name,a.last_name FROM user_master a,user_organization b WHERE b.direct_report_to='$employee' AND a.username=b.username ORDER BY a.username";
					$sub_result = mysql_query($sub_sql);
					$i=0;
					while ($sub_row = mysql_fetch_row($sub_result)){
						echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
						$list[$i]="$sub_row[0]";
					$i++;
					}
					
               		$sub_sql = "SELECT b.username,a.first_name,a.last_name FROM user_master a,user_organization b WHERE b.dot_report_to='$employee' AND a.username=b.username ORDER BY a.username";
					$sub_result = mysql_query($sub_sql);														
					while ($sub_row = mysql_fetch_row($sub_result)){
						echo "<option value='$sub_row[0]'>$sub_row[1] $sub_row[2]</option>";
						$list[$i]="$sub_row[0]";
					}
					
					for($i=0;$i<count($list);$i++){
						$value="'$list[$i]'";
						$report_list.=$value;
						if($i<count($list)-1){
							$report_list.=",";
						}
					}				
            ?>
        </select>
	</td>

	<td><font face=Verdana size=1><b>From Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=from_date id="from_date" readonly onclick="fPopCalendar('from_date')"></td>
	
	<td><font face=Verdana size=1><b>To Date</td>
	<td><input style="font-size: 8pt; font-family: Arial; width: 75px;" name=to_date id="to_date" readonly onclick="fPopCalendar('to_date')"></td>
</tr>
<tr bgcolor="#CCCCCC">
	<td><font face=Verdana size=1><b>Project / Activity</td>
	<td>
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
	
	

	<td><font face=Verdana size=1><b>Client / Agency</td>
	<td>
        <select size=1 name=agency_index style="font-size: 8pt; font-family: Arial">
		<option value=''></option>
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
	
	<td align="center" colspan=2>
	<input type=submit value="SEARCH" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>


</tr>
</form>
</table>
<br>
</center>

<?
	$sql="select a.record_index,a.username,a.project_code,a.date,a.hours,a.task,b.project_code,b.project_description,c.agency_code,d.first_name,d.last_name,d.staff_number";
	$sql.=" from timesheet a, timesheet_project_code b,agency c, user_master d";
	$sql.=" where date>='$from_date' and date<='$to_date' ";
	$sql.=" and a.username like '%$username%'";
	$sql.=" and a.username in ($report_list)";
	$sql.=" and a.agency_index like '%$agency_index%' and a.project_code like '%$project_code%' and a.username=d.username and a.project_code=b.project_code and a.agency_index=c.agency_index order by a.username,a.date";
	$result = mysql_query($sql);	
	$record_count=mysql_num_rows($result);
	if ($record_count>0){
?>
		<table border=1 width=100% cellspacing=0 cellpadding=1 style="border-collapse: collapse" bordercolor="#E5E5E5">
		<tr>
			<td colspan=7 align=right><b><a href='timesheets_export.php?from_date=<?echo $from_date;?>&to_date=<? echo $to_date;?>&agency_index=<? echo $agency_index;?>&project_code=<?echo $project_code;?>&username=<?echo $username;?>'><font face=Arial size=1>Export to Excel</font></a></b></td>
		</tr>
		<tr>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Staff Name</font></b></td>
			<td bgcolor=#3366CC align=center width=60><font color=white  face=Arial size=2><b>Staff No</font></b></td>
			<td bgcolor=#3366CC align=center width=60><font color=white  face=Arial size=2><b>Date</font></b></td>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Client</font></b></td>
			<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Project / Activity </font></b></td>
			<td bgcolor=#3366CC align=center width=200><font color=white  face=Arial size=2><b>Details</font></b></td>
			<td bgcolor=#3366CC align=center width=60><font color=white  face=Arial size=2><b>Hours</font></b></td>
		</tr>
<? 
		$row_color="#FFFFFF";
		$total_hours=0;
		while ($row=mysql_fetch_row($result)){
			$actual_date=date("d-m-Y","$row[3]");
			$row[5]=str_replace("\n","<br>","$row[5]");
?>		
		<tr bgcolor=<?echo $row_color; ?>>
		<td align=left><font color=#003366 face='Verdana' size=1><? echo "$row[9] $row[10]"; ?></font></td>
		<td align=left><font color=#003366 face='Verdana' size=1><? echo "$row[11]"; ?></font></td>
		<td align=center><font color=#003366 face='Verdana' size=1><? echo "$actual_date"; ?></font></td>
		<td align=center><font color=#003366 face='Verdana' size=1><? echo "$row[8]"; ?></td>
		<td align=left><font color=#003366 face='Verdana' size=1><? echo "$row[7]"; ?></td>
		<td align=left><font color=#003366 face='Verdana' size=1><? echo "$row[5]"; ?></td>
		<td align=center><font color=#003366 face='Verdana' size=1><? echo "$row[4]"; ?></td>
		</tr>
<?
		}
	}
?>
</table>