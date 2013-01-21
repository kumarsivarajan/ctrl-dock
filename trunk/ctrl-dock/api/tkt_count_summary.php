<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
// This API is used to count the number of tickets, open, close, total
// ticket_count.php?key=abcd&type=open
// by default it returns the total number of tickets unless a specific type is mentioned

function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$type			= strip_tags($_REQUEST['type']);
$staff			= strip_tags($_REQUEST['staff']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	echo "<node>";
	echo "<summary>";
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' AND track_id!=999999");
	$open = mysql_num_rows($result);
	echo "<open>".$open."</open>";
	
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and priority_id='1' AND track_id!=999999");
	$low = mysql_num_rows($result);
	echo "<low>".$low."</low>";
	
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and priority_id='2' AND track_id!=999999");
	$normal = mysql_num_rows($result);
	echo "<normal>".$normal."</normal>";
	
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and priority_id='3' AND track_id!=999999");
	$high = mysql_num_rows($result);
	echo "<high>".$high."</high>";
	
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and priority_id='4' AND track_id!=999999");
	$emergency = mysql_num_rows($result);
	echo "<emergency>".$emergency."</emergency>";

	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and priority_id='5' AND track_id!=999999");
	$exception = mysql_num_rows($result);
	echo "<exception>".$exception."</exception>";
	
	$result = mysql_query("SELECT * FROM isost_ticket a, isost_staff b WHERE a.staff_id=b.staff_id and a.status='open' and b.username='$staff' AND track_id!=999999");
	$staff = mysql_num_rows($result);
	echo "<staff>".$staff."</staff>";
	
	$result = mysql_query("SELECT * FROM isost_ticket WHERE status = 'open' and staff_id='0' AND track_id!=999999");
	$unassigned = mysql_num_rows($result);
	echo "<unassigned>".$unassigned."</unassigned>";

	echo "</summary>";
	echo "</node>";
}

?>