<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is used to list all the service properties

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
global $service;
if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){		
			echo "<service>";
				echo "<service>".$service."</service>";
				echo "<type>".$row['type']."</type>";
				echo "<url>".$row['url']."</url>";
				echo "<port>".$row['port']."</port>";
				echo "<username>".$row['username']."</username>";
				echo "<password>".$row['password']."</password>";
				echo "<domain>".$row['domain']."</domain>";
			echo "</service>";
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
$service		= strip_tags($_REQUEST['service']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$result = mysql_query("SELECT * FROM service_properties WHERE service = '$service'");		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>
