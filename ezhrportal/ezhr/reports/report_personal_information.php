
<?php 

$report_type="Staff_Personal_Information";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");

$check_service = "HRMS";
include_once("../auth.php");

$sql = "SELECT a.staff_number,a.first_name,a.last_name,b.date_of_joining,b.date_of_leaving,b.date_of_birth,b.blood_group,b.marital_status,b.date_of_marriage,";
$sql.= "b.passport_number,b.passport_issue_location,b.passport_issue_date,b.passport_valid_till";
$sql.= " FROM user_master a,user_personal_information b ";
$sql.= " WHERE a.username=b.username and a.account_type not in ('external_user','service_account') ORDER BY a.first_name";
$result = mysql_query($sql);

echo "Staff No.,Name,Date of Joining,Date of Leaving,Date of Birth,Blood Group,Marital Status,Date of Marriage,Passport No.,Passport Issue Location,Passport Issue Date,Passport Valid Till\n";

$i=1;

while ($row = mysql_fetch_row($result)){
	
	echo "\"$row[0]\",\"$row[1] $row[2]\",";
	echo "\"".date("m/d/Y",$row[3])."\",";
	echo "\"".date("m/d/Y",$row[4])."\",";
	echo "\"".date("m/d/Y",$row[5])."\",";
	echo "\"$row[6]\",\"$row[7]\",";
	echo "\"".date("m/d/Y",$row[8])."\",";
	echo "\"$row[9]\",";
	echo "\"$row[10]\",";
	echo "\"".date("m/d/Y",$row[11])."\",";
	echo "\"".date("m/d/Y",$row[12])."\",";
	echo "\"$row[13]\"\n";
	$i++;
}
?>