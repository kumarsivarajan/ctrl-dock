<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is list all the hosts by the software installed
// oa_list_hosts_by_sw.php?key=abcd&id=6

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
					echo "<uuid>".$row['software_uuid']."</uuid>";
					echo "<hostname>".$row['system_name']."</hostname>";
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
require_once('../include/dboa.php');

$api_key		= strip_tags($_REQUEST['key']);
$id				= strip_tags($_REQUEST['id']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "SELECT distinct system_name,software_uuid FROM software,system,software_register WHERE software_name=software_title AND software_uuid=system_uuid AND software_reg_id='$id'";
		$result = mysql_query($sql);	
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>