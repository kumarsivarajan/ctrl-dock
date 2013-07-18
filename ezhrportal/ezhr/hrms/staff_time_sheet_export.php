<?

$report_type="Time_Sheet";
$date=date("dmy_His");
$account=$_REQUEST['account'];

if (strlen($account)==0){
	$header_name="ALL";
}else{
	$sql="select first_name,last_name from user_master where username='$account'";
	$result = mysql_query($sql);														
	$row = mysql_fetch_row($result);
	$header_name=$row[0]." ".$row[1];
}
$file_name=$report_type."_".$date."_".$header_name.".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment;filename=$file_name");

include("../auth.php");
include("../include/css/default.css");

$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];
$agency_index=$_REQUEST['agency_index'];
$project_index=$_REQUEST['project_index'];

	$sql="select c.name,b.description,a.start_date,a.end_date,a.activity,d.first_name,d.last_name,e.project_description from timesheet a,timesheet_context b,agency c,user_master d,timesheet_project e";
	$sql.=" where a.context_id=b.context_id and a.agency_index=c.agency_index and a.username=d.username and a.project_index=e.project_index";
	$sql.=" and a.start_date>='$from_date' and a.end_date<='$to_date' and a.agency_index like '$agency_index%' and a.project_index like '$project_index%'";
	if($header_name=="ALL"){
		$sql.=" and a.username in (select username from user_organization where direct_report_to='$employee' or dot_report_to='$employee')";
	}else {
		$sql.=" and a.username='$account'";
	}
	$sql.=" order by a.start_date";
	$result = mysql_query($sql);	
	$record_count=mysql_num_rows($result);
	if ($record_count>0){
?>
		<table border=0 width=100% cellspacing=1 cellpadding=3 class=reporttable>
		<tr>
			<td class=reportheader width=180>Staff</font></b></td>
			<td class=reportheader width=90>Start Date / Time</font></b></td>
			<td class=reportheader width=90>End Date / Time</font></b></td>
			<td class=reportheader width=50>Hours</font></b></td>
			<td class=reportheader width=90>Context</font></b></td>
			<td class=reportheader width=200>Client</font></b></td>
			<td class=reportheader width=200>Project</font></b></td>
			<td class=reportheader>Activity </font></b></td>
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
			$project_description=$row[7];
?>		
			<tr>
			<td class=reportdata><?=$name;?></td>
			<td class=reportdata style='text-align:center;'><?=$start_date;?></td>
			<td class=reportdata style='text-align:center;'><?=$end_date;?></td>
			<td class=reportdata style='text-align:center;'><?=$hours;?></td>
			<td class=reportdata style='text-align:center;'><?=$context;?></td>
			<td class=reportdata><?=$agency;?></td>
			<td class=reportdata><?=$project_description;?></td>
			<td class=reportdata><?=$activity;?></td>
<?
		}
?>
		<tr>
			<td class=reportheader colspan=3 style='text-align:right;'>TOTAL&nbsp;</font></b></td>
			<td class=reportheader style='text-align:center;'><?=$total_hours;?>&nbsp;</font></b></td>
			<td class=reportheader colspan=3>&nbsp;</td>
		</tr>
</table>
<?
	}
?>
