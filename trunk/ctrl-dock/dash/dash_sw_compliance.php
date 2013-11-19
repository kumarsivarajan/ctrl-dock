<?
include_once("../include/config.php");
include_once("../include/css/default.css");
include_once("../include/load_xml.php");


$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

// To display software compliance summary
$oa_compliance=1;
$url=$base_url."/api/oa_sw_register.php?key=$API_KEY";
$inactive_host_list=array();
$inactive_host_count=0;
if ($query = load_xml($url)){	
	for($i=0;$i<count($query);$i++){
		$title=$query->software[$i]->title;
		if(strlen($title)>0){
			$license_purchased	=$query->software[$i]->license_purchased;
			$software_used		=$query->software[$i]->software_used;
			$type				=$query->software[$i]->type;
			$active_count		=$query->software[$i]->active_hosts_count;
			$inactive_count		=$query->software[$i]->inactive_hosts_count;
			$sw_a_host			=$query->software[$i]->active_hosts;
			$sw_ia_host			=$query->software[$i]->inactive_hosts;
			
			$slno				=$i+1;

		
			$count=$active_count+$inactive_count;
			$status_color="black";
			if ($count>$license_purchased){$count_print="(".$count.")";$status_color="red";} else{$count_print=$count;}
		
			if($license_purchased<0){$status_color="black";}		
		
			$status="Compliant";
			$status_color="green";
			if ($count>$license_purchased){$oa_compliance=0;}
		}
	}
}
$status="Compliant";
$status_color="#339933";
if ($oa_compliance==0){$status="Not Compliant";$status_color="#CC0000";}

?>