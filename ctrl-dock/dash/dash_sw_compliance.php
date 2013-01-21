<?
include_once("include/config.php");
include_once("include/css/default.css");
include_once("include/load_xml.php");


$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

// To display software compliance summary

$url=$base_url."/api/oa_sw_register.php?key=$API_KEY";
$inactive_host_list=array();
$inactive_host_count=0;
$oa_compliance="1";
if ($query = load_xml($url)){	
	for($i=0;$i<count($query);$i++){
		$id=$query->software[$i]->id;
		if(strlen($id)>0){
		$title=$query->software[$i]->title;
		$license_purchased=$query->software[$i]->license_purchased;
		$software_used=$query->software[$i]->software_used;
		$slno=$i+1;
		
		$sub_url_1=$base_url."/api/oa_list_hosts_by_sw.php?key=$API_KEY&id=$id";
		$active_count=0;
		$inactive_count=0;
		
		$sw_a_host="LIST OF ACTIVE HOSTS FOR $title<br><br>";
		$sw_ia_host="LIST OF IN-ACTIVE HOSTS FOR $title<br><br>";
		
		if ($sub_query_1 = load_xml($sub_url_1)){
			for($j=0;$j<count($sub_query_1);$j++){
				$hostname=$sub_query_1->host[$j]->hostname;
				
				$sub_url_2=$base_url."/api/ast_information.php?key=$API_KEY&hostname=$hostname";
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
		}
		$count=$active_count+$inactive_count;
		$status_color="black";
		if ($count>$license_purchased){$count_print="(".$count.")";$status_color="red";} else{$count_print=$count;}
		
		if($license_purchased<0){$status_color="black";}
		

		if ($count>$license_purchased && $license_purchased>0){$oa_compliance=0;}	
		}
	}
}
$status="Compliant";
$status_color="#339933";
if ($oa_compliance==0){$status="Not Compliant";$status_color="#CC0000";}

?>