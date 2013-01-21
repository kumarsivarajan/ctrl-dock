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
			echo "<staffname>Unassigned</staffname>";
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

$api_key		  =$_REQUEST['key'];
$currenttimestamp =$_REQUEST['currtimestamp'];
$num_rows		  = '';
$status			  =$_REQUEST["status"];

$qstatus="SELECT t.ticket_id,t.subject,t.helptopic,t.status from isost_ticket t where t.ticket_id>0 ";

if($status == 'open')
{
	$qstatus .= " and t.staff_id=0 and t.status='open' ";
}
elseif($status == 'transfered')
{
	$qstatus = "select t.ticket_id,t.subject,t.helptopic,t.status from isost_ticket t inner join isost_ticket_note tn on t.ticket_id=tn.ticket_id where t.status='open' and tn.title like 'Dept. Transfer %' and tn.staff_id=0";
}
elseif($status == 'closed')
{
	$qstatus .= " and t.status='closed' and t.staff_id=0 ";
}
elseif($status == 'overdue')
{
	$qstatus .= " and t.isoverdue=1 and t.status='open' ";
}

$query=" AND UNIX_TIMESTAMP(t.created) <= $currenttimestamp order by t.ticket_id desc";


if($api_key!=$API_KEY || $api_key==''){
	invalid();
}
else
{
		$sql = "$qstatus $query";
		$result = mysql_query($sql);	
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}		

?>
