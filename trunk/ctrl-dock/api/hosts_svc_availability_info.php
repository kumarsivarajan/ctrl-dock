<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the service uptime details for a particular host for a given duration
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

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$hostname		= strip_tags($_REQUEST['hostname']);
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		echo "<node>";
			
			$sql="select a.port,a.description from hosts_service a, hosts_master b where a.host_id=b.host_id and b.hostname='$hostname' and a.enabled=1 and b.status=1";
			echo $sql;
			$result = mysql_query($sql);
			
			while ($row = mysql_fetch_row($result)){
				$sub_sql="SELECT COUNT(*) FROM hosts_service_log a, hosts_master b,hosts_service c WHERE a.host_id=b.host_id AND a.host_id=c.host_id ";
				$sub_sql.=" AND b.hostname='$hostname' AND b.status='1' AND c.enabled='1' AND a.svc_status='1' AND a.port='$row[0]' AND a.timestamp>=$start_date AND a.timestamp<=$end_date";
				$sub_result = mysql_query($sub_sql);
				$sub_row = mysql_fetch_row($sub_result);
				$upcount=$sub_row[0];
				
				$sub_sql="SELECT COUNT(*) FROM hosts_service_log a, hosts_master b,hosts_service c WHERE a.host_id=b.host_id AND a.host_id=c.host_id ";
				$sub_sql.=" AND b.hostname='$hostname' AND b.status='1' AND c.enabled='1' AND a.svc_status='0' AND a.port='$row[0]' AND a.timestamp>=$start_date AND a.timestamp<=$end_date";
				$sub_result = mysql_query($sub_sql);
				$sub_row = mysql_fetch_row($sub_result);
				$downcount=$sub_row[0];
				
				
				$total=$upcount+$downcount;
				$uptime_percentage	=($upcount/$total)*100;
				$uptime_percentage=round($uptime_percentage,2);
			
				$downtime_percentage=($downcount/$total)*100;
				$downtime_percentage=round($downtime_percentage,2);
				
			
			
				echo "<service_info>";
					echo "<port>".$row[0]."</port>";
					echo "<description>".$row[1]."</description>";		
					echo "<uptime>".$uptime_percentage."</uptime>";		
				echo "</service_info>";
			}
			
		echo "</node>";
	
}
?>