<?php


header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is list all the hosts by the software installed
// oa_list_hosts_by_sw.php?key=abcd&title=Microsoft Office Enterprise 2007

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
		while($row = mysql_fetch_array($result)){		
			echo "<host>";
				echo "<hostname>".$row['hostname']."</hostname>";
			echo "</host>";
		}
	}
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/dboa.php');

$api_key		= strip_tags($_REQUEST['key']);
$title			= strip_tags($_REQUEST['title']);
$type			= strip_tags($_REQUEST['type']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	echo "<node>";
		if ($type=="KEY"){
			$sql = "SELECT distinct a.hostname from system a,sys_sw_software_key b where a.system_id=b.system_id and b.key_name='$title'";
			$result = mysql_query($sql);	
			$num_rows = mysql_num_rows($result);
			showxml($result, $num_rows);
		}
		if ($type=="OTHER"){
			$sql = "SELECT distinct a.hostname from system a,sys_sw_software b where a.system_id=b.system_id and b.software_name='$title'";
			$result = mysql_query($sql);	
			$num_rows = mysql_num_rows($result);
			showxml($result, $num_rows);
		}	
	echo "</node>";
}
?>