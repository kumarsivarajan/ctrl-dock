<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";


// This API is used to list all the softwares in the software register along with the number of licenses that have been purchased for each of them.
// oa_sw_register.php?key=abcd


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
				$software_title	=$row['key_name'];
				
				$sub_result = mysql_query("SELECT SUM(quantity) AS license_purchased FROM sw_licenses WHERE package_name='$software_title'");
				$sub_row = mysql_fetch_array($sub_result);
				$license_purchased=$sub_row['license_purchased'];
				
				$sub_result = mysql_query("SELECT COUNT(key_name) as license_used FROM sys_sw_software_key WHERE key_name='$software_title'");
				$sub_row = mysql_fetch_array($sub_result);
				$license_used=$sub_row['license_used'];
				
			
				echo "<software>";
					echo "<title><![CDATA[".$software_title."]]></title>"; 
					echo "<license_purchased>".$license_purchased."</license_purchased>";
					echo "<software_used>".$license_used."</software_used>";
				echo "</software>";
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

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql="SELECT distinct key_name from sys_sw_software_key order by key_name";

		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>
