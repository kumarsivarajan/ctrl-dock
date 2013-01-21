<?php
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list all the tickets based on states
// tkt_list_by_states.php?key=abcd&state=closed
// by default it returns all the tickets unless a specific state is mentioned
// possible states : open, closed

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
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){
				$staff_id=$row['staff_id'];
				$staff_name="";
				$sub_result = mysql_query("SELECT firstname,lastname FROM isost_staff where staff_id=$staff_id");				
				$sub_row = mysql_fetch_array($sub_result);
				$staff_name=$sub_row['firstname']." " .$sub_row['lastname'];
			
			echo "<ticket>";
				echo "<tid>".$row['ticket_id']."</tid>";
				echo "<dept_id>".$row['dept_id']."</dept_id>";
				echo "<topic_id>".$row['topic_id']."</topic_id>";
				echo "<priority_id>".$row['priority_id']."</priority_id>";
				echo "<staff>".$staff_name."</staff>";
				echo "<email>".$row['email']."</email>";
				echo "<name>".$row['name']."</name>";
				echo "<subject><![CDATA[".$row['subject']."]]></subject>";
				echo "<helptopic>".$row['helptopic']."</helptopic>";
				echo "<status>".$row['status']."</status>";
				echo "<source>".$row['source']."</source>";
				echo "<duedate>".$row['duedate']."</duedate>";
				echo "<created>".$row['created']."</created>";
				echo "<updated>".$row['updated']."</updated>";
				echo "<isoverdue>".$row['isoverdue']."</isoverdue>";
				echo "<ip_address>".$row['ip_address']."</ip_address>";
			echo "</ticket>";
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
$state			= strip_tags($_REQUEST['state']);
$number			= strip_tags($_REQUEST['number']);
if($number==''){$number=50;}

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	// check for state
	if($state==''){
		$result = mysql_query("SELECT * FROM isost_ticket order by ticket_id DESC LIMIT $number");
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
	}
	if($state=='open' || $state=="closed"){
		$result = mysql_query("SELECT * FROM isost_ticket WHERE status = '$state' order by ticket_id DESC LIMIT $number");		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
	}
}
?>
