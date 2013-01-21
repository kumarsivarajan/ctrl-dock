<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is used to list all the services enabled for a user

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
				echo "<name>".$row["service"]."</name>";
				echo "<display>".$row["comments"]."</display>";
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
$user			= strip_tags($_REQUEST['user']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$result = mysql_query("SELECT b.service,c.comments FROM user_group a,group_service b,services c WHERE a.group_id=b.group_id AND b.service=c.service AND a.username='$user'");		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>
