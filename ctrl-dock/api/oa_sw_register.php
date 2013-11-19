<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";


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

function sw_key_based($result, $num_rows){

global $base_url;
global $API_KEY;

if($num_rows>0){
			while($row = mysql_fetch_array($result)){
				$key_name	= $row['key_name'];
				$software_title=html_entity_decode($key_name);
				
				$license_purchased=0;$license_used=0;
				
				$sub_result = mysql_query("SELECT SUM(quantity) AS license_purchased FROM sw_licenses WHERE package_name='$key_name'");
				$sub_row = mysql_fetch_array($sub_result);
				$license_purchased=$sub_row['license_purchased'];
								
				$sub_result = mysql_query("SELECT distinct system_id FROM sys_sw_software_key WHERE key_name='$key_name' group by system_id");
				$license_used=mysql_num_rows($sub_result);
				
				
				$sw_a_host="LIST OF ACTIVE HOSTS FOR $software_title : ";
				$sw_ia_host="LIST OF IN-ACTIVE HOSTS FOR $software_title : ";
				$active_count=0;$inactive_count=0;
				
				$sub_result = mysql_query("SELECT distinct a.hostname from system a,sys_sw_software_key b where a.system_id=b.system_id and b.key_name='$key_name'");
				while($sub_row = mysql_fetch_array($sub_result)){
					$hostname=$sub_row[0];
					
					$sub_url_2=$base_url."api/ast_information.php?key=$API_KEY&hostname=$hostname";
					$sub_query_2 = load_xml($sub_url_2);
					$status=$sub_query_2->asset[0]->status;
					
					if($status=="Active"){
						$active_count++;
						$sw_a_host.="   $hostname   ";
					}else{
						$inactive_count++;
						$inactive_host_list[$inactive_host_count]=$hostname;
						$inactive_host_count++;
						$sw_ia_host.="   $hostname   ";
					}
				}

				echo "<software>";
					echo "<title>".$software_title."</title>";
					echo "<license_purchased>".$license_purchased."</license_purchased>";
					echo "<software_used>".$license_used."</software_used>";
					echo "<type>KEY</type>";
					echo "<active_hosts>".$sw_a_host."</active_hosts>";
					echo "<active_hosts_count>".$active_count."</active_hosts_count>";
					echo "<inactive_hosts>".$sw_ia_host."</inactive_hosts>";
					echo "<inactive_hosts_count>".$inactive_count."</inactive_hosts_count>";
				echo "</software>";
			}
		}
}

function sw_others($result, $num_rows){
global $base_url;
global $API_KEY;

if($num_rows>0){

			while($row = mysql_fetch_array($result)){
				$package_name	= $row['package_name'];
				$package_name	=html_entity_decode($package_name);
		
				$license_purchased=0;$license_used=0;
				
				$sub_result = mysql_query("SELECT SUM(quantity) AS license_purchased FROM sw_licenses WHERE package_name='$package_name'");
				$sub_row = mysql_fetch_array($sub_result);
				$license_purchased=$sub_row['license_purchased'];
								
				$sub_result = mysql_query("SELECT distinct system_id FROM sys_sw_software WHERE software_name like '$package_name%' group by system_id");
				$license_used=mysql_num_rows($sub_result);
				
				$sw_a_host="LIST OF ACTIVE HOSTS FOR $software_title : ";
				$sw_ia_host="LIST OF IN-ACTIVE HOSTS FOR $software_title : ";
				$active_count=0;$inactive_count=0;
				
				$sub_result = mysql_query("SELECT distinct a.hostname from system a,sys_sw_software b where a.system_id=b.system_id and b.software_name like '$package_name%'");
				while($sub_row = mysql_fetch_array($sub_result)){
					$hostname=$sub_row[0];
					
					$sub_url_2=$base_url."api/ast_information.php?key=$API_KEY&hostname=$hostname";
					$sub_query_2 = load_xml($sub_url_2);
					$status=$sub_query_2->asset[0]->status;
					
					if($status=="Active"){
						$active_count++;
						$sw_a_host.="   $hostname   ";
					}else{
						$inactive_count++;
						$inactive_host_list[$inactive_host_count]=$hostname;
						$inactive_host_count++;
						$sw_ia_host.="   $hostname   ";
					}
				}
				
				
				echo "<software>";
					echo "<title>".$package_name."</title>";
					echo "<license_purchased>".$license_purchased."</license_purchased>";
					echo "<software_used>".$license_used."</software_used>";
					echo "<type>OTHER</type>";
					echo "<active_hosts>".$sw_a_host."</active_hosts>";
					echo "<active_hosts_count>".$active_count."</active_hosts_count>";
					echo "<inactive_hosts>".$sw_ia_host."</inactive_hosts>";
					echo "<inactive_hosts_count>".$inactive_count."</inactive_hosts_count>";
				echo "</software>";
			}
		}
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/load_xml.php');
require_once('../include/dboa.php');


$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;


$api_key		= strip_tags($_REQUEST['key']);

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		echo "<node>";
		$sql="SELECT distinct key_name from sys_sw_software_key order by key_name";
		mysql_query("SET NAMES `utf8`");
		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		sw_key_based($result, $num_rows);
		
		$sql="SELECT distinct package_name from sw_licenses where package_name not in (SELECT distinct key_name from sys_sw_software_key order by key_name) order by package_name";
		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		sw_others($result, $num_rows);
		echo "</node>";
}
?>
