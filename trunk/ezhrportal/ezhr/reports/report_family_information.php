
<?php 

$report_type="Staff_Family_Information";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";


header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");


$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");


$sql = "SELECT a.staff_number,a.first_name,a.last_name,b.member_name,b.relationship,b.member_date_of_birth,b.member_blood_group,b.dependent";
$sql.= " FROM user_master a,user_family_member b ";
$sql.= " WHERE a.username=b.username and account_type not in ('external_user','service_account') ORDER BY a.staff_number";
$result = mysql_query($sql);
echo "\"Staff\",\"Name\",\"Family Member\",\"Relationship\",\"Date of Birth\",\"Blood Group\",\"Dependent\"\n";

$i=1;

while ($row = mysql_fetch_row($result)){

		$emp_no=$row[0];
		$name=$row[1]." ".$row[2];
		
		echo "\"$emp_no\",\"$name\",\"$row[3]\",\"$row[4]\",";
		
		if(date("Y",$row[5])>1970){
			echo "\"".date("d-m-Y",$row[5])."\"";
		}else{
			echo "\"$row[5]\"";
		}
		
		echo ",\"$row[6]\",\"$row[7]\"\n";
	$i++;
}
