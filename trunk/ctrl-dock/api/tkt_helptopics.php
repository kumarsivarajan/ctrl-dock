<?php
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list all the tickets based on helptopic
// tkt_helptopics.php?key=abcd
// by default it returns all the tickets unless a specific topic is mentioned

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
			echo "<helptopic>";
				echo "<topic>".$row['topic']."</topic>";
				echo "<topic_id>".$row['topic_id']."</topic_id>";
			echo "</helptopic>";
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
	$result = mysql_query("SELECT * FROM isost_help_topic order by topic");
	$num_rows = mysql_num_rows($result);
	showxml($result, $num_rows);
}
?>
