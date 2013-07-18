
<?php 

$report_type="Staff_General_Information";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";


header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");

$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");

$sql = "SELECT staff_number,first_name,last_name,account_type,account_status,contact_phone_residence,contact_phone_mobile,contact_address,permanent_address,office_index,business_group_index,agency_index,username,grade_id,official_email,personal_email from user_master where account_type not in ('external_user','service_account') order by first_name";
$result = mysql_query($sql);

echo "\"Staff\",\"First_Name\",\"Last_Name\",\"Type\",\"Agency\",\"Status\",\"Date of Joining\",\"Date of Leaving\",\"Business Group\",\"Grade\",\"Title\",\"Reporting Manager\",";
echo "\"Dotted Line Manager\",\"Country\",\"Contact - Residence\",\"Contact - Mobile\",\"Address - Contact\",\"Address - Permanent\",\"Username\",\"Education\",\"Official E-Mail\",\"Personal E-Mail\"\n";


while ($row = mysql_fetch_row($result)){

	echo "\"$row[0]\",\"$row[1]\",\"$row[2]\",\"$row[3]\",";

	$sub_sql="select name from agency where agency_index='$row[11]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "\"$sub_row[0]\",";
	echo "\"$row[4]\",";
	

	$sub_sql="select date_of_joining,date_of_leaving from user_personal_information where username='$row[12]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "\"".date("m/d/Y",$sub_row[0])."\",";
	echo "\"".date("m/d/Y",$sub_row[1])."\",";
	

	$sub_sql="select business_group,prefix from business_groups where business_group_index='$row[10]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "\"$sub_row[0]\",\"$sub_row[1] $row[13]\",";

	$sub_sql="select title,direct_report_to,dot_report_to from user_organization where username='$row[12]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$direct_report_to=$sub_row[1];
	$dot_report_to=$sub_row[2];
	
	echo "\"$sub_row[0]\",";

	$sub_sql="select first_name,last_name from user_master where username='$direct_report_to'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$fullname=$sub_row[0]." ".$sub_row[1];
	
	echo "\"$fullname\",";

	$sub_sql="select first_name,last_name from user_master where username='$dot_report_to'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$fullname=$sub_row[0]." ".$sub_row[1];
	
	echo "\"$fullname\",";

	$sub_sql="select country from office_locations where office_index='$row[9]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	echo "\"$sub_row[0]\",";
	echo "\"$row[5]\",";
	echo "\"$row[6]\",";
	echo "\"$row[7]\",";
	echo "\"$row[8]\",";
	echo "\"$row[12]\",";
	
	$sub_sql="select * from user_education where username='$row[12]'";
	$sub_result = mysql_query($sub_sql);
	$education="";
	while ($sub_row = mysql_fetch_row($sub_result)){
		$education.=$sub_row[2] . " | " . $sub_row[3] . " | " . $sub_row[5];
		$education.="||";
	}

	echo "\"$education\",";	
	echo "\"$row[14]\",";
	echo "\"$row[15]\"\n";
	$i++;
}
?>