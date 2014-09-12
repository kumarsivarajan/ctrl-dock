<?

include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/system_config.php");
include_once("../include/load_xml.php");
include_once("../include/host_nw.php");

if($ezRIM==1){

	//Exception,Emergency,High,Normal,Low,Unassigned,Network Status,Service Status
	
	$summary=array();
	
	// Fetch count of tickets for priority
	
	$sql	="SELECT priority_id,priority_desc FROM isost_ticket_priority order by priority_id DESC";
	$result = mysql_query($sql);
	$i=0;
	
	while($row = mysql_fetch_array($result)){
		$priority_id=$row['priority_id'];
		$priority_desc=$row['priority_desc'];
		
		$sub_sql 	= "SELECT * from isost_ticket where priority_id='$priority_id' and status='open' AND track_id!=999999";
		$sub_result = mysql_query($sub_sql);
		$count 		= mysql_num_rows($sub_result);
		
		$summary[$i]=$count;
		
		$i++;
	}
	
	// Fetch count of Un-assigned tickets
	$sql="SELECT count(*) FROM isost_ticket WHERE STATUS='open' AND staff_id='0' AND track_id!=999999";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$summary[$i]=$row[0];	
	$i++;
	
	
	// Fetch Network Status Summary
	$sql = "SELECT a.host_id FROM hosts_nw a, hosts_master b WHERE enabled='1' AND b.status='1' AND a.host_id=b.host_id ORDER BY host_id";
	$result = mysql_query($sql);
	$status=1;
	while($row = mysql_fetch_array($result)){
		$sub_sql	="SELECT nw_status FROM hosts_nw_log WHERE host_id='$row[0]' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);	
		$sub_row 	= mysql_fetch_array($sub_result);
		$status		= $sub_row[0];				
		if($status==0){
			break;
		}
	}
	$summary[$i]=$status;	
	$i++;
	
	// Fetch Service Status Summary
	$sql = "SELECT a.host_id,a.port FROM hosts_service a, hosts_master b WHERE enabled='1' AND b.status='1' AND a.host_id=b.host_id ORDER BY host_id";
	$result = mysql_query($sql);
	
	$status=1;
	
	while($row = mysql_fetch_array($result)){
		$host_id	=$row[0];
		$port		=$row[1];
				
		$sub_sql	="SELECT svc_status FROM hosts_service_log WHERE host_id='$host_id' and port='$port' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);
		$sub_row 	= mysql_fetch_array($sub_result);
		$status		= $sub_row[0];
		if($status==0){
			$status=0;
			break;
		}
	}
	$summary[$i]=$status;	
	$i++;
		
	
	// Fetch Performance Status Summary
	$sql = "select a.host_id from hosts_nw_snmp a,hosts_master b where a.enabled='1' AND b.status='1' AND a.host_id=b.host_id";
	$result = mysql_query($sql);
	
	$up_status	=0;
	$total		=0;

	while($row = mysql_fetch_array($result)){
		$host_id	=$row[0];
		$sub_sql	="SELECT nw_snmp_cpu_status,nw_snmp_mem_status,nw_snmp_dsk_status FROM hosts_nw_snmp_log WHERE host_id='$host_id' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);
		$sub_row 	= mysql_fetch_array($sub_result);
		
		if(mysql_num_rows($sub_result)>0){
			if ($sub_row[0]==1){$up_status++;}$total++;
			if ($sub_row[1]==1){$up_status++;}$total++;
			if ($sub_row[2]==1){$up_status++;}$total++;
		}		
	}
	$status=0;
	if ($up_status == $total){$status=1;}
	
	$summary[$i]=$status;

	$i++;
	
	// Update RIM Master
	$url=$MASTER_URL."/api/rim_master_update.php";	
	
	$fields = array(
		'key'=>urlencode($MASTER_API_KEY),		
		'agency'=>urlencode($AGENCY_ID),
		'exception'=>urlencode($summary[0]),
		'emergency'=>urlencode($summary[1]),
		'high'=>urlencode($summary[2]),
		'normal'=>urlencode($summary[3]),
		'low'=>urlencode($summary[4]),
		'unassigned'=>urlencode($summary[5]),
		'hosts_nw_status'=>urlencode($summary[6]),
		'hosts_svc_status'=>urlencode($summary[7]),
		'hosts_perf_status'=>urlencode($summary[8])
	);
	
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
				
	$ch = curl_init();	
			
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_TIMEOUT,60);		
	curl_setopt($ch, CURLOPT_POST,count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	$data = curl_exec($ch);	
			
	curl_close($ch);
	
	
	// Update the Current Count of Tickets in an Engineer's name
	
	// First fetch list of all valid users
	$sql="select staff_id,email from isost_staff where isactive='1' order by firstname";
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_array($result)){
		$staff_id	=$row[0];
		$email		=$row[1];
		
		// Fetch number of tickets that are open
		$sub_sql="select count(*) from isost_ticket where status='open' and staff_id='$staff_id' AND track_id!=999999";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_array($sub_result);
		$ticket_count=$sub_row[0];
		
		rim_master_mytickets($email,$ticket_count);
	}
}

// Update network status to RIM Master
if($ezRIM==1){
	$sql = "SELECT hostname,platform,description from hosts_master WHERE status='1' ORDER BY hostname";
	$result = mysql_query($sql);	
	$num_rows = mysql_num_rows($result);

	if($num_rows>0){
		while($row = mysql_fetch_array($result)){		
				$hostname=$row[0];
				$platform=$row[1];			
				if(strlen($row[2])>0){$description=$row[2];	}
							
				$network=get_nw_status($hostname);
				
				list($live,$count)=get_svc_status($hostname,$base_url,$API_KEY);
				list($snmp,$network_snmp_cpu_status,$cpu,$network_snmp_mem_status,$mem,$network_snmp_dsk_status,$dsk)=get_snmp_status($hostname);
				
				// Update RIM Master
				$url=$MASTER_URL."/api/rim_master_nw.php";
				$fields=array();$fields_string="";
				$fields = array(
					'key'=>urlencode($MASTER_API_KEY),		
					'agency'=>urlencode($AGENCY_ID),		
					'hostname'=>urlencode($hostname),
					'description'=>urlencode($description),
					'platform'=>urlencode($platform),
					'network'=>urlencode($network),
					'live'=>urlencode($live),
					'count'=>urlencode($count),
					'snmp'=>urlencode($snmp),
					'network_snmp_cpu_status'=>urlencode($network_snmp_cpu_status),
					'cpu'=>urlencode($cpu),
					'network_snmp_mem_status'=>urlencode($network_snmp_mem_status),
					'mem'=>urlencode($mem),
					'network_snmp_dsk_status'=>urlencode($network_snmp_dsk_status),
					'dsk'=>urlencode($dsk)
				);
				
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string,'&');
											
				$ch = curl_init();	
						
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
				curl_setopt($ch, CURLOPT_TIMEOUT,60);		
				curl_setopt($ch, CURLOPT_POST,count($fields));
				curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
				$data = curl_exec($ch);	
						
				curl_close($ch);
			}
		}
}



function rim_master_mytickets ($assigned_to,$ticket_count){
	global $MASTER_URL,$MASTER_API_KEY,$AGENCY_ID;
	
	// Update RIM Master
	$url=$MASTER_URL."/api/rim_master_mytickets.php";			
	
	$fields = array(
		'key'=>urlencode($MASTER_API_KEY),		
		'agency'=>urlencode($AGENCY_ID),		
		'assigned_to'=>urlencode($assigned_to),
		'ticket_count'=>urlencode($ticket_count)		
	);
	
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
				
	$ch = curl_init();	
			
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_TIMEOUT,60);		
	curl_setopt($ch, CURLOPT_POST,count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	$data = curl_exec($ch);	
			
	curl_close($ch);
}

?>