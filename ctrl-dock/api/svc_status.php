<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the summary status of the services on all hosts being monitored. 
// svc_status.php?key=abcd


function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function showxml($result, $num_rows){
if($num_rows>0){
			echo "<node>";
			$status=1;
			while($row = mysql_fetch_array($result)){
				$host_id	=$row[0];
				$port		=$row[1];
				
				$sub_sql	="SELECT svc_status FROM hosts_service_log WHERE host_id='$host_id' and port='$port' ORDER BY record_id DESC LIMIT 1";				
				$sub_result = mysql_query($sub_sql);	
				$sub_row 	= mysql_fetch_array($sub_result);
				$status		= $sub_row[0];
				if($status==0){
					$status=0;
					break;
				}
			}				
			echo "<summary>".$status."</summary>";
			echo "</node>";
	}
}
// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "SELECT a.host_id,a.port FROM hosts_service a, hosts_master b WHERE enabled='1' AND b.status='1' AND a.host_id=b.host_id ORDER BY host_id";
		$result = mysql_query($sql);	

		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);		
}
?>
