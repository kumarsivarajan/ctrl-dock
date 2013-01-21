<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the last known status of the services for a given host
// hosts_svc_status.php?key=abcd&hostname=server.domain.com


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
					echo "<port><![CDATA[".$row[1]."]]></port>";
					echo "<description><![CDATA[".$row[2]."]]></description>";
					
					$sub_sql="SELECT svc_status,timestamp from hosts_service_log where port='$row[1]' and host_id='$row[0]' order by record_id DESC LIMIT 1";
					$sub_result = mysql_query($sub_sql);	

					$sub_row = mysql_fetch_array($sub_result);
					
					echo "<svc_status><![CDATA[".$sub_row[0]."]]></svc_status>";					
					echo "<timestamp><![CDATA[".$sub_row[1]."]]></timestamp>";
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
		$sql = "SELECT a.host_id,b.port,b.description FROM hosts_master a,hosts_service b WHERE a.host_id=b.host_id AND b.enabled='1' AND a.hostname='$hostname' ORDER BY port";
		$result = mysql_query($sql);	

		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);		
}
?>
