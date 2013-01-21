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
				$software_id	=$row['software_reg_id'];
				$software_title	=$row['software_title'];
				$software_used  =$row['number_used'];
				$sub_result = mysql_query("SELECT SUM(license_purchase_number) AS license_purchased FROM software_licenses, software_register WHERE license_software_id = software_reg_id AND software_reg_id = '$software_id'");
				$sub_row = mysql_fetch_array($sub_result);
			
				echo "<software>";
					echo "<id>".$software_id."</id>";
					echo "<title><![CDATA[".$software_title."]]></title>"; 
					echo "<license_purchased>".$sub_row['license_purchased']."</license_purchased>";
					echo "<software_used>".$software_used."</software_used>";
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
		$sql = "SELECT software_reg_id, software_title, count(software.software_name) AS number_used FROM ";
		$sql .= "software_register, software, system WHERE ";
		$sql .= "software_title = software_name AND ";
		$sql .= "software_uuid = system_uuid AND ";
		$sql .= "software_timestamp = system_timestamp ";
		$sql .= "GROUP BY software_title";
		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>
