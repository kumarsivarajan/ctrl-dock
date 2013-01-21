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

function showxml($result, $num_rows){
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){		
				echo "<status>";
					echo "<host_id><![CDATA[".$row[0]."]]></host_id>";
					echo "<nw_status><![CDATA[".$row[1]."]]></nw_status>";
					echo "<ping_min><![CDATA[".$row[2]."]]></ping_min>";
					echo "<ping_avg><![CDATA[".$row[3]."]]></ping_avg>";
					echo "<ping_max><![CDATA[".$row[4]."]]></ping_max>";					
					echo "<timestamp><![CDATA[".$row[5]."]]></timestamp>";
				echo "</status>";
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
$hostname		= strip_tags($_REQUEST['hostname']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "SELECT a.host_id,b.nw_status,b.min,b.avg,b.max,b.timestamp FROM hosts_master a,hosts_nw_log b WHERE a.host_id=b.host_id AND a.hostname='$hostname' ORDER BY b.record_id DESC LIMIT 1";
		$result = mysql_query($sql);	

		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);		
}
?>
