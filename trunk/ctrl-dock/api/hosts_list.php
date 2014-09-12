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

function showxml($result, $num_rows){
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){						
				echo "<host>";
					echo "<hostname><![CDATA[".$row[0]."]]></hostname>";					
					echo "<platform><![CDATA[".$row[1]."]]></platform>";
					
					$description=$row[0];
					
					if(strlen($row[2])>0){
						$description=$row[2];
					}
					
					echo "<description><![CDATA[".$description."]]></description>";					
				echo "</host>";				
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
if (isset($_REQUEST['count'])){
	$count	= " limit ". $_REQUEST['count'];
}else{
	$count="";
}


$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "SELECT hostname,platform,description from hosts_master WHERE status='1' ORDER BY hostname $count ";
		$result = mysql_query($sql);	

		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);		
}
?>
