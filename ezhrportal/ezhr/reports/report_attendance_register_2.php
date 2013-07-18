<?php 

$report_type="Leave_Attendance_Register";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment;filename=$file_name");


include("config.php");
include("../include/date.php"); 

$account_status=$_REQUEST['account_status'];

$from_date=$_REQUEST['from_date'];
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);
$period=(($to_date-$from_date)/86400)+1;

?>

<h2>Attendance Register : <? echo $_REQUEST['from_date'];?> to <? echo $_REQUEST['to_date'];?></h2>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
	<td bgcolor=#3366CC align=center width=150><font color=white  face=Arial size=2><b>Staff Name</font></b> </td>
	<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Staff No.</font></b> </td>
	<td bgcolor=#3366CC align=center><font color=white  face=Arial size=2><b>Working Days</font></b> </td>
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>Days Worked</font></b></td>
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>Annual Leave</font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>Casual Leave</font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>Comp Off</font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>LOP</font></b></td>	
	<td bgcolor=#3366CC align=center ><font color=white  face=Arial size=2><b>Total Leave Availed</font></b></td>

</tr>
<?

	$last_month_start=mktime(0,0,0,date(m),date(d),date(y))-(date(d)*86400);
	$last_month_start=$last_month_start-(30*86400);
	
	$sql= "SELECT a.username,a.first_name,a.last_name,a.staff_number,a.account_type,a.account_status 
	FROM user_master a, user_personal_information b 
	WHERE a.username=b.username AND (b.date_of_leaving>'$last_month_start' OR b.date_of_leaving='') AND b.date_of_joining<$to_date AND a.account_status='$account_status' and staff_number NOT LIKE 'C%'  
	ORDER BY first_name";

	
	$result = mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	
	while ($row = mysql_fetch_row($result)){		
		$sub_sql="SELECT from_date,to_date,leave_category_id";
		$sub_sql.=" FROM leave_form WHERE ";
		$sub_sql.="((to_date>='$from_date' AND to_date<='$to_date') OR ";
		$sub_sql.="(from_date>='$from_date' AND to_date<='$to_date') OR"; 		
		$sub_sql.="(from_date>='$from_date' AND from_date<='$to_date')) ";
		$sub_sql.="AND leave_status='1' AND username='$row[0]' ORDER BY from_date";
		
		$sub_result = mysql_query($sub_sql);
			
		$no_days=0;
		$total_days=0;
		$al=0;
		$cl=0;
		$col=0;
		$lop=0;
		$days_worked=0;
		
		while ($sub_row = mysql_fetch_row($sub_result)){
			
			$start		=$sub_row[0];
			$end		=$sub_row[1];
			$category	=$sub_row[2];
			
			if ($from_date>$start){
				$start =$from_date;
			}
			if ($to_date<$end){
				$end	=$to_date;
			}

			$no_days=(($end-$start)/86400)+1;
			$no_days=round($no_days,0);
			
			if($category==1){$al=$al+$no_days;}
			if($category==2){$cl=$cl+$no_days;}
			if($category==3){$lop=$lop+$no_days;}
			if($category==4){$col=$col+$no_days;}
			
			$total_days=$total_days+$no_days;
		}
		$days_worked=$period-$total_days;
		
?>
		<tr>
			<td align=left><font color=#003366 face=Arial size=2><? echo "$row[1] $row[2]";?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo "$row[3]";?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $period;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $days_worked;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $al;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $cl;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $col;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $lop;?></font></td>
			<td align=left><font color=#003366 face=Arial size=2><? echo $total_days;?></font></td>			
		</tr>
<?		
		}
?>
</table>
