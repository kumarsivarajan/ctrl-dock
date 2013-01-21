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
				echo "<terminal>";
					echo "<servicename>".$row[2]."</servicename>";					
					echo "<url>".$row[0]."</url>";
					echo "<serviceusername>".$row[1]."</serviceusername>";
					echo "<servicetype>".$row[3]."</servicetype>";	
				echo "</terminal>";				
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
$username		= strip_tags($_REQUEST['username']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "select sp.url,sp.username,sp.service,sp.type from user_group ug inner join group_service gs inner join service_properties sp on ug.group_id=gs.group_id and gs.service=sp.service where ug.username='$username' and sp.type='SSH'";
		$result = mysql_query($sql);	

		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);		
}
?>
