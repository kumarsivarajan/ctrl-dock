<?php 
include("../common/config.php");


$handle = fopen("leave_record.csv", "r");
$i=0;
while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
	$username			=$data[0];
	
	$from_date			=$data[1];
	$from_date			=date_to_int($from_date);
	$to_date			=$data[2];
	$to_date			=date_to_int($to_date);
	
	$reason				=$data[3];
	if ($reason=="HD"){$from_date=$from_date+43200;$reason="";}
	$leave_category_id	=$data[4];
	$leave_status		=$data[5];
	$approval_username	=$data[6];
	$approval_date		=$data[7];
	$approval_date		=date_to_int($approval_date);
	$comments			=$data[8];
	
    $sql = "insert into leave_form (username,from_date,to_date,reason,leave_category_id,leave_status,approval_date,approval_username,comments)";
	$sql.= " values ('$username','$from_date','$to_date','$reason','$leave_category_id','$leave_status','$approval_date','$approval_username','$comments')";	
    $result = mysql_query($sql);
	
	sleep(1);

	$i++;
	print "Processing record $i\n";
}

function date_to_int ($calendar_date){
	$day=substr($calendar_date,3,2);
	$month=substr($calendar_date,0,2);	
	$year=substr($calendar_date,6,4);	
	$date_int=mktime(0,0,0,$month,$day,$year);	
	return($date_int);
}
?>