<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the list of hosts that are to be monitored.
// hosts_svc_status.php?key=abcd


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

function showxml($result, $num_rows,$staffname){
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){						
				echo "<staffdetails>";
					echo "<ticketid>".$row[0]."</ticketid>";
					echo "<staffname>".$staffname."</staffname>";
					echo "<subject><![CDATA[".$row[1]."]]></subject>";
					echo "<helptopic><![CDATA[".$row[2]."]]></helptopic>";
					echo "<status>".$row[3]."</status>";
				echo "</staffdetails>";				
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

$api_key		=$_REQUEST['key'];
$staffid		=$_REQUEST['staffid'];
$num_rows		= '';
$start_date		=$_REQUEST["start_date"];
$end_date		=$_REQUEST["end_date"];
$status			=$_REQUEST["status"];

$qstatus="SELECT t.ticket_id,t.subject,t.helptopic,t.status from isost_ticket t where t.staff_id='$staffid' ";
$strStatus = "created";
if($status == 'open'){
	$qstatus .= "and t.status='open'";
}elseif($status == 'transfered'){
	$qstatus = "select t.ticket_id,t.subject,t.helptopic,t.status from isost_ticket t inner join isost_ticket_note tn on t.ticket_id=tn.ticket_id where t.status='open' and tn.title like 'Dept. Transfer %' and tn.staff_id='$staffid'";
}elseif($status == 'closed'){
	$qstatus .= "and t.status='closed'";
	$strStatus = "closed";
}elseif($status == 'overdue'){
	$qstatus .= "and t.isoverdue=1 and t.status='open'";
}

if (strlen($start_date)>0 && strlen($end_date)>0){
	$start_date		= strip_tags($_REQUEST['start_date']);
	$end_date		= strip_tags($_REQUEST['end_date']);
	$end_date		+= 86399;

	$query="AND UNIX_TIMESTAMP(t." .$strStatus . ") >= $start_date and UNIX_TIMESTAMP(t." .$strStatus . ") <= $end_date";
}else{
	$query="";
}

if($api_key!=$API_KEY || $api_key==''){
	invalid();
}
else
{
		$sql1= mysql_query("select firstname,lastname from isost_staff where staff_id='$staffid'");
		$row1=mysql_fetch_row($sql1);
		$staffname=$row1[0].' '.$row1[1];
		$sql = "$qstatus $query";
		$result = mysql_query($sql);	
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows,$staffname);
}		

?>
