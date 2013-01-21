<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list all the tickets based on helptopic
// tkt_list_by_helptopics.php?key=abcd&topic=Desktop : Operating System&status=open
// by default it returns all the tickets unless a specific topic is mentioned

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
				echo "<staff>".$staff_name."</staff>";
				echo "<email>".$row['email']."</email>";
				echo "<name>".$row['name']."</name>";
				echo "<subject>".$row['subject']."</subject>";
				echo "<helptopic>".$row['helptopic']."</helptopic>";
				echo "<status>".$row['status']."</status>";
				echo "<source>".$row['source']."</source>";
				echo "<duedate>".$row['duedate']."</duedate>";
				echo "<created>".$row['created']."</created>";
				echo "<updated>".$row['updated']."</updated>";
				echo "<ip_address>".$row['ip_address']."</ip_address>";
				
				$ticket_id=$row['ticket_id'];
				$sub_sql="SELECT created,staff_name,response FROM isost_ticket_response where ticket_id='$ticket_id' order by response_id";				
				$sub_result = mysql_query($sub_sql);				
				
				while($sub_row = mysql_fetch_array($sub_result)){				
					$note=$note.$sub_row['created']." > ".$sub_row['staff_name']." > ".$sub_row['response']."||";
				}
				echo "<note>".$note."</note>";
				$note="";
				$note_staff_name="";
				
				
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
$topic			= strip_tags($_REQUEST['topic']);
$status			= strip_tags($_REQUEST['status']);if($status=='all'){$status='%';}
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);
$end_date		+= 86399;

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	$sql="SELECT * FROM isost_ticket WHERE helptopic = '$topic' and status like '$status' and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date order by ticket_id";
	$result = mysql_query("SELECT * FROM isost_ticket WHERE helptopic = '$topic' and status like '$status' and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date order by ticket_id");
	$num_rows = mysql_num_rows($result);
	showxml($result, $num_rows);
}
?>
