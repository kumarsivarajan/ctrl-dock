<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the last known status and ping statistics of the hosts' network interface
// hosts_nw_status.php?key=abcd&hostname=server.domain.com


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

function getupcount($result){
	$upcount = 0;
	$prev_time = 0;
	$first_time = 1;
	$countingstarted = 0;
	while ($row = mysql_fetch_row($result)){
		if ($countingstarted == '0'){ 
			if ($row[1] == '0'){ //We are yet to encounter an up status
				continue;
			}else{ // we encountered the first up status
				$countingstarted = '1';
				$prev_time = $row[0];
			}
		}else{
			$upcount += $row[0] - $prev_time;
			$prev_time = $row[0];
			if ($row[1] == '1'){ //Counting has started and we have encountered another up status; Ignore

			}else{  //Counting has started and we encountered our first down time; get the time difference and get the total updated;
					//and reset the counter
				$countingstarted = 0;
			}
		}				
	}
	$upcount_hrs = round ($upcount/3600,2);
	return $upcount_hrs;
}

function getdowncount($result, $endtime){
	$downcount = 0;
	$prev_time = 0;
	$first_time = 1;
	$countingstarted = 0;
	while ($row = mysql_fetch_row($result)){
		if ($countingstarted == '0'){ 
			if ($row[1] == '1'){ //We are yet to encounter a down status
				continue;
			}else{ // we encountered the first down status
				$countingstarted = '1';
				$prev_time = $row[0];
			}
		}else{
			$downcount += $row[0] - $prev_time;
			$prev_time = $row[0];
			if ($row[1] == '0'){ //Counting has started and we have encountered another down status; Ignore
				
			}else{  //Counting has started and we encountered our first up time; get the time difference and get the total updated;
					//and reset the counter				
				$countingstarted = 0;
			}
		}				
	}
	$downcount_hrs = round ($downcount/3600,2);
	return $downcount_hrs;
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$hostname		= strip_tags($_REQUEST['hostname']);
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);
$end_date		+= 86399;

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		echo "<node>";
		
			$sql="SELECT a.timestamp,a.nw_status FROM hosts_nw_log a, hosts_master b,hosts_nw c ";
			$sql.=" WHERE a.host_id=b.host_id AND a.host_id=c.host_id AND b.hostname='$hostname' AND";
			$sql.=" b.status='1' AND c.enabled='1' AND a.timestamp>= $start_date AND a.timestamp<= $end_date order by record_id";
 
			$result = mysql_query($sql);
			$downcount_hrs = getdowncount($result);
			mysql_data_seek($result, 0);
			$upcount_hrs = getupcount($result);
			$total = $upcount_hrs + $downcount_hrs;
	
			
			$uptime_percentage	= round(($upcount_hrs/$total)*100, 2);
			$downtime_percentage = round(($downcount_hrs/$total)*100, 2);
			echo "<availability>";
				echo "<uptime>".$uptime_percentage."</uptime>";
				echo "<uptime_hrs>".$upcount_hrs."</uptime_hrs>";
				echo "<downtime>".$downtime_percentage."</downtime>";
				echo "<downtime_hrs>".$downcount_hrs."</downtime_hrs>";
			echo "</availability>";

			
		echo "</node>";
}
?>
