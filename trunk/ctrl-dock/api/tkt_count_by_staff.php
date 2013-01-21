<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to count the number of tickets based on the staff who have been assigned to address the issue
// ticket_count_by_staff.php?key=abcd
// Possible Values are 
// start_date 	= start of the date range in unix timestamp
// end_date 	= end of the date range in unix timestamp

function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

function showxml($result, $num_rows){
global $status,$start_date,$end_date;

if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){
				$staff_name=$row[0];
				$sub_sql="SELECT DISTINCT(ticket_id) FROM isost_ticket_note WHERE UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and source='$staff_name'";
				$sub_result = mysql_query($sub_sql);						
				$count = mysql_num_rows($sub_result);
				
			echo "<ticketcount>";
				echo "<staff>".$staff_name."</staff>";
				echo "<count>".$count."</count>";
			echo "</ticketcount>";
			}
			echo "</node>";
		}else{
			$nodata = 0;
			success($nodata);
		}
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);
$end_date		+= 86399;

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql="SELECT DISTINCT(source) FROM isost_ticket_note WHERE UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date AND source!='system' ORDER BY note_id,ticket_id";
		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>