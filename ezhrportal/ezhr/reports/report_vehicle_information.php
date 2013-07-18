
<?php 

$report_type="Staff_Vehicle_Information";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");

$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");

$sql = "SELECT a.staff_number,a.first_name,a.last_name,b.vehicle_type,b.vehicle_make,b.vehicle_no,a.username";
$sql.= " FROM user_master a,user_vehicle b ";
$sql.= " WHERE a.username=b.username and a.account_type not in ('external_user','service_account') ORDER BY a.staff_number";
$result = mysql_query($sql);

echo "\"Staff\",\"Name\",\"Vehicle Type\",\"Vehicle Make\",\"Vehicle Reg. No.\",\"License No.\",\"License Issue Date\",\"License Validity\"\n";

$i=1;
while ($row = mysql_fetch_row($result)){

	echo "\"$row[0]\",\"$row[1] $row[2]\",\"$row[3]\",\"$row[4]\",\"$row[5]\",";
	
	$sub_sql="select license_no,license_issue_date,license_valid_till from user_driving_license where category like '%$row[3]%' and username='$row[6]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	echo "\"$sub_row[0]\",";
	if (strlen($sub_row[1])>0){
		echo "\"".date("m/d/Y",$sub_row[1])."\",";
	}else{
		echo "\"\",";
	}
	if (strlen($sub_row[2])>0){
		echo "\"".date("m/d/Y",$sub_row[2])."\"\n";
	}else{
		echo "\"\"\n";
	}
	$i++;
}
?>
