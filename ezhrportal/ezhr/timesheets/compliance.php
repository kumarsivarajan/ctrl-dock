<?php 

include_once("config.php");
include_once("date_to_int.php");

$from_date		=$_REQUEST['from_date'];
$xls_from_date	=$from_date;
$to_date		=$_REQUEST['to_date'];
$xls_to_date	=$to_date;

$xls		=$_REQUEST['xls'];if(strlen($xls)==0){$xls=0;}

if($xls==1){
	$report_type="Time_Sheet_Compliance_Report";
	$date=date("dmy_His");
	$file_name=$report_type."_".$date.".xls";

	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=$file_name");
}

//$search_end_date=date('d-m-Y');
//$search_from_date=date('d-m-Y',mktime()-(86400*7));

?>
<center>
<?
if($xls==0){
include_once("header.php");
include_once("calendar.php");
?>
<table border=0 width=100% cellspacing=0 cellpadding=2>
<form method=POST action="compliance.php">
<tr bgcolor="#CCCCCC">
	<td><font face=Arial size=1><b>&nbsp;COMPLIANCE REPORT</td>
	
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
<?}?>

<?
if(strlen($from_date)>0 && strlen($to_date)>0){
	$from_date=search_date_to_int($from_date,0,0);
	$to_date=search_date_to_int($to_date,23,59);

	$sql="select a.username,a.first_name,a.last_name,b.business_group,b.business_group_index,a.staff_number";
	$sql.=" from user_master a, business_groups b";
	$sql.=" where a.business_group_index=b.business_group_index and a.account_status='Active' order by a.first_name";
	$result = mysql_query($sql);	
	$record_count=mysql_num_rows($result);

	if ($record_count>0){
?>
		<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
		<?if($xls==0){?>
		<tr>
			<td colspan=9 class=reportdata style='text-align:right;'><a href='compliance.php?xls=1&from_date=<?=$xls_from_date?>&to_date=<?=$xls_to_date?>'>Export to Excel</a>
			</td>
		</tr>
		<?}?>
		<tr>
			<td class=reportheader width=180>Staff</td>
			<td class=reportheader width=50>Staff ID</td>
			<td class=reportheader width=100>Business Group</td>
			<td class=reportheader width=100>Reporting Manager</td>
			<td class=reportheader width=100>Dotted Line Manager</td>
			<td class=reportheader width=50>To Log<br>Hrs</td>
			<td class=reportheader width=50>Logged<br>Hrs</td>
			<td class=reportheader width=50>Leave<br>Hrs</td>
			<td class=reportheader width=50>Compliance</td>
		</tr>
<? 
		$row_color="#FFFFFF";
		$total_hours=0;
		while ($row=mysql_fetch_row($result)){	
		
			$account		=$row[0];
			$staff			=$row[1]." ".$row[2];
			$business_group	=$row[3];
			$business_group_index	=$row[4];
			$staff_number	=$row[5];
			
			// Fetch the minimum hours for the business group
			$sub_sql="select min_hrs from timesheet_minhrs where business_group_index='$business_group_index'";	
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$min_hrs		=$sub_row[0];
			if($min_hrs==0){$min_hrs=175;}
			
			// Fetch user id's of direct and dotted line reporting managers
			$sub_sql="select title,direct_report_to,dot_report_to from user_organization where username='$account'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$direct_report_to=$sub_row[1];
			$dot_report_to=$sub_row[2];
			
			// Fetch Timesheet Information
			
			$sub_sql="select start_date,end_date,context_id from timesheet";
			$sub_sql.=" where start_date>='$from_date' and end_date<='$to_date' and username='$account'";
			$sub_sql.=" order by start_date";

			$sub_result = mysql_query($sub_sql);
			
			$total_hours=0;
			$leave_hours=0;
			
			if(mysql_num_rows($sub_result)){
				while ($sub_row=mysql_fetch_row($sub_result)){
					$context_id =$sub_row[2];
					$start_date	=date("d-m-Y H:i","$sub_row[0]");
					$end_date	=date("d-m-Y H:i","$sub_row[1]");
					$hours=round((($sub_row[1]-$sub_row[0])/3600),1);
					if($context_id==4){
						$leave_hours=$leave_hours+$hours;
					}else{
						$total_hours=$total_hours+$hours;
					}
				}
			}
			$compliance="Yes";
			if($total_hours<$min_hrs){
				$compliance="No";
			}
			
			$sub_sql="select count(*) from timesheet_exception where username='$account'";
			$sub_result = mysql_query($sub_sql);
			$exception_row=mysql_fetch_row($sub_result);
			$exception=$exception_row[0];
			if($exception==1){
				$compliance="Approved Exception";
			}
?>		
			<tr>
			<td class=reportdata><?=$staff;?></td>
			<td class=reportdata><?=$staff_number;?></td>
			<td class=reportdata><?=$business_group;?></td>
			
<?	
			$sub_sql="select first_name,last_name from user_master where username='$direct_report_to'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$fullname=$sub_row[0]." ".$sub_row[1];
?>
			<td class=reportdata><?=$fullname; ?></td>
<?	
			$sub_sql="select first_name,last_name from user_master where username='$dot_report_to'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			$fullname=$sub_row[0]." ".$sub_row[1];
?>
			<td class=reportdata><?=$fullname; ?></td>
			<td class=reportdata><?=$min_hrs;?></td>
			<td class=reportdata><?=$total_hours;?></td>
			<td class=reportdata><?=$leave_hours;?></td>
			<td class=reportdata><?=$compliance;?></td>
			
			</tr>
<?
		}
?>
</table>
<?
	}
}
?>
