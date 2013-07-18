<?php 

$report_type="Leave_Report";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";


header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");


$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");

$from_date=$_REQUEST['from_date'];
$from_date=date_to_int($from_date);

$to_date=$_REQUEST['to_date'];
$to_date=date_to_int($to_date);

	echo "\"Staff\",\"Title\",\"Business Group\",\"Leave From\",\"Leave To\",\"Days\",\"Type\"\n";


	$sql="SELECT a.username,b.first_name,b.last_name,a.from_date,a.to_date,a.leave_category_id,a.leave_status";
	$sql.=" FROM leave_form a, user_master b WHERE from_date>='$from_date' and a.from_date<='$to_date' and a.username=b.username and leave_status='1' order by from_date";

	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)){
	
		$agencies="";
		$sub_sql="SELECT title from user_organization where username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$title=$sub_row[0];
		
		$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		
		$business_group=$sub_row[0];
		
		$sub_sql="SELECT b.business_group from user_master a, business_groups b where a.business_group_index=b.business_group_index and a.username='$row[0]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		
		
		if($row[6]==0){$status="Pending Approval";}
		if($row[6]==1){$status="Approved";}
		if($row[6]==2){$status="Rejected";}
		if($row[6]==3){$status="Cancelled";}
		
		$sub_sql="SELECT leave_category from leave_type where leave_category_id='$row[5]'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$leave_type=$sub_row[0];
		
		$start=$row[4];
		if($row[4]>$to_date){$start=$to_date;}
		
		$no_days=($start-$row[3])/86400;
		if($no_days<0){$no_days=0;}
		$no_days=$no_days+1;
		$no_days=round($no_days,0);
		
		$start=date("m/d/Y",$row[3]);
		$end=date("m/d/Y",$row[4]);
		echo "\"$row[1] $row[2]\",\"$title\",\"$business_group\",\"$start\",\"$end\",\"$no_days\",\"$leave_type\"\n";
		
		$i++;
	}

?>