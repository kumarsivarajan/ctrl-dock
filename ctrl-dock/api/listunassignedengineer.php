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

function showxml($timestamp){

	$noofunassignedtickets = 0;
	$noofopentickets = 0;
	$noofclosedtickets = 0;
	$noofslabreached = 0;
	$nooftransfered = 0;

	echo "<node>";
		$sql1=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='open' and t.staff_id=0 AND UNIX_TIMESTAMP(t.created) <= $timestamp");
		$row1=mysql_fetch_row($sql1);
		$noofunassignedtickets=$row1[0];

		$sql2=mysql_query("select count(t.ticket_id) from isost_ticket t where t.isoverdue=1 and t.status='open' and t.staff_id=0 AND UNIX_TIMESTAMP(t.created) <= $timestamp");
		$row2=mysql_fetch_row($sql2);
		$noofslabreached=$row2[0];

		$sql3=mysql_query("select count(t.ticket_id) from isost_ticket t inner join isost_ticket_note tn on t.ticket_id=tn.ticket_id where t.status='open' and tn.title like 'Dept. Transfer %' and tn.staff_id=0 AND UNIX_TIMESTAMP(t.created) <= $timestamp");
		$row3=mysql_fetch_row($sql3);
		$nooftransfered=$row3[0];
		
		$sql4=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='closed' and t.staff_id=0 AND UNIX_TIMESTAMP(t.created) <= $timestamp");
		$row4=mysql_fetch_row($sql4);
		$noofclosedtickets=$row4[0];
		
		$sql5=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='open' AND UNIX_TIMESTAMP(t.created) <= $timestamp");
		$row5=mysql_fetch_row($sql5);
		$noofopentickets=$row5[0];
					
		echo "<staff>";
		echo "<firstname>Unassigned</firstname>";
		echo "<unassigned>".$noofunassignedtickets."</unassigned>";
		echo "<openticket>".$noofopentickets."</openticket>";
		echo "<closedticket>".$noofclosedtickets."</closedticket>";
		echo "<transferedticket>".$nooftransfered."</transferedticket>";
		echo "<slabreached>".$noofslabreached."</slabreached>";
		echo "</staff>";				

	echo "</node>";
		
}
// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		=$_REQUEST['key'];
$timestamp		=$_REQUEST['currtimestamp'];

if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	showxml($timestamp);
}		

?>
