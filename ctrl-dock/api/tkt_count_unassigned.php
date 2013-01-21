<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to count the number of tickets that are un-assigned

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
global $status,$period,$value;


if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){
				$count=$row[0];				
						
				echo "<unassigned>";
					echo "<count>".$count."</count>";	
				echo "</unassigned>";
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
$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$result = mysql_query("SELECT count(*) FROM isost_ticket WHERE STATUS='open' AND staff_id='0'");
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>