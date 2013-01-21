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

function showxml($result, $num_rows, $query,$status){
	if($num_rows>0){
		$noofopentickets = 0;
		$noofclosedtickets = 0;
		$noofslabreached = 0;
		$nooftransfered = 0;

		echo "<node>";
		while($row = mysql_fetch_array($result)){
			$staffid=$row[0];
			if(strlen($status) > 0){
				if($status == 'open'){
					$sql1=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='$status' and t.staff_id='$staffid' $query");
					$row1=mysql_fetch_row($sql1);
					$noofopentickets=$row1[0];
					
					$sql2=mysql_query("select count(t.ticket_id) from isost_ticket t where t.isoverdue=1 and t.status='$status' and t.staff_id='$staffid' $query");
					$row2=mysql_fetch_row($sql2);
					$noofslabreached=$row2[0];
				}
			
				if($status == 'transfered'){
					$sql3=mysql_query("select count(t.ticket_id) from isost_ticket t inner join isost_ticket_note tn on t.ticket_id=tn.ticket_id where t.status='open' and tn.title like 'Dept. Transfer %' and tn.staff_id='$staffid' $query");
					$row3=mysql_fetch_row($sql3);
					$nooftransfered=$row3[0];
					$noofopentickets=$row3[0];
				}
			
				if($status == 'closed'){
					$sql4=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='$status' and t.staff_id='$staffid' $query");
					$row4=mysql_fetch_row($sql4);
					$noofclosedtickets=$row4[0];
				}
			}else{
				$sql1=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='open' and t.staff_id='$staffid' $query");
				$row1=mysql_fetch_row($sql1);
				$noofopentickets=$row1[0];
			
				$sql2=mysql_query("select count(t.ticket_id) from isost_ticket t where t.isoverdue=1 and t.status='open' and t.staff_id='$staffid' $query");
				$row2=mysql_fetch_row($sql2);
				$noofslabreached=$row2[0];
			
				$sql3=mysql_query("select count(t.ticket_id) from isost_ticket t inner join isost_ticket_note tn on t.ticket_id=tn.ticket_id where t.status='open' and tn.title like 'Dept. Transfer %' and tn.staff_id='$staffid' $query");
				$row3=mysql_fetch_row($sql3);
				$nooftransfered=$row3[0];
				
				$sql4=mysql_query("select count(t.ticket_id) from isost_ticket t where t.status='closed' and t.staff_id='$staffid' $query");
				$row4=mysql_fetch_row($sql4);
				$noofclosedtickets=$row4[0];
			}
			
			
			echo "<staff>";
				echo "<staffid>".$staffid."</staffid>";					
				echo "<firstname>".$row[1]."</firstname>";
				echo "<lastname>".$row[2]."</lastname>";
				echo "<openticket>".$noofopentickets."</openticket>";
				echo "<closedticket>".$noofclosedtickets."</closedticket>";
				echo "<transferedticket>".$nooftransfered."</transferedticket>";
				echo "<slabreached>".$noofslabreached."</slabreached>";
			echo "</staff>";				
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
$num_rows		= '';
$staff			=$_REQUEST['staff'];
$start_date		=$_REQUEST["start_date"];
$end_date		=$_REQUEST["end_date"];
$status			=$_REQUEST["status"];

if (strlen($start_date)>0 && strlen($end_date)>0){
	$start_date		= strip_tags($_REQUEST['start_date']);
	$end_date		= strip_tags($_REQUEST['end_date']);
	$end_date		+= 86399;
	if ($status == "closed"){
		$query="AND UNIX_TIMESTAMP(t.closed) >= $start_date and UNIX_TIMESTAMP(t.closed) <= $end_date";
	}else{
		$query="AND UNIX_TIMESTAMP(t.created) >= $start_date and UNIX_TIMESTAMP(t.created) <= $end_date";
	}
}else{
	$query="";
}

if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	$sql = "SELECT staff_id,firstname,lastname from isost_staff where email = '$staff'";
	$result = mysql_query($sql);	
	$num_rows = mysql_num_rows($result);
	showxml($result,$num_rows,$query,$status);
}		

?>
