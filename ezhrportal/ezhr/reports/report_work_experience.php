
<?php 

$report_type="Staff_Work_Experience";
$date=date("dmy_His");
$file_name=$report_type."_".$date.".csv";

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");

$check_service = "HRMS";
include_once("../auth.php");
include_once("../include/date.php");


$sql = "SELECT a.staff_number,a.first_name,a.last_name,b.organization,b.from_date,b.to_date,a.username,c.date_of_joining";
$sql.= " FROM user_master a,user_experience b,user_personal_information c ";
$sql.= " WHERE a.username=b.username and a.username=c.username and a.account_status='Active' and a.account_type not in ('external_user','service_account') ORDER BY a.first_name,(b.from_date+0) asc";
$result = mysql_query($sql);

echo "\"Staff No.\",\"Name\",\"Organization\",\"From Date\",\"To Date\",\"Experience\",\"Total Experience\"\n";

$i=1;
$total_diff=0;
while ($row = mysql_fetch_row($result)){
	$username=$row[6];	
	$date=$row[5];
	
	if($username!=$last_username && $i>1){
		$total_diff=0;
		$curexp=((mktime()-$doj)/86400)/365.25;
		$curexp=round($curexp,1);
		$total_exp=$last_diff+$curexp;
		
		echo "\"$last_staff_no\",\"$last_name\",\"This Organization\",";
		echo "\"".date("m/d/Y",$doj)."\",";
		echo "\"".date("m/d/Y",mktime())."\",";
		echo "\"$curexp\",\"$total_exp\"\n";	
	}

	echo "\"$row[0]\",\"$row[1] $row[2]\",\"$row[3]\",";

	$diff=(($row[5]-$row[4])/86400)/365.25;
	$diff=round($diff,1);
	$total_diff=$total_diff+$diff;

	echo "\"".date("m/d/Y",$row[4])."\",";
	echo "\"".date("m/d/Y",$row[5])."\",";
	echo "\"$diff\",\"$total_diff\"\n";	

	$i++;
	$last_date=$row[5];
	$last_username=$username;
	$last_diff=$total_diff;
	$last_staff_no=$row[0];
	$last_name=$row[1]." ".$row[2];
	$doj=$row[7];
}

	$curexp=((mktime()-$doj)/86400)/365.25;
	$curexp=round($curexp,1);
	$final_row_exp=$total_diff+$curexp;
	
	echo "\"$last_staff_no\",\"$last_name\",\"This Organization\",";
	echo "\"".date("m/d/Y",$doj)."\",";
	echo "\"".date("m/d/Y",mktime())."\",";
	echo "\"$curexp\",\"$final_row_exp\"";	

?>