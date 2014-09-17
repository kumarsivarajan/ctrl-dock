<?
function get_nw_status($hostname){
		$sql="select a.host_id from hosts_nw a,hosts_master b where a.host_id=b.host_id and enabled='1' and b.hostname='$hostname'";
		$result = mysql_query($sql);
		$enabled = mysql_num_rows($result);
		
		if ($enabled==1){
			$sql="SELECT b.nw_status FROM hosts_master a,hosts_nw_log b WHERE a.host_id=b.host_id AND a.hostname='$hostname' ORDER BY b.record_id DESC LIMIT 1";
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
			$network=$row[0];
		}else {
			$network=11;
		}
		return($network);// 1=OK,0=DOWN,11=NA
}


function get_svc_status($hostname){
		
		$sql = "SELECT a.host_id,b.port,b.description FROM hosts_master a,hosts_service b WHERE a.host_id=b.host_id AND b.enabled='1' AND a.hostname='$hostname' ORDER BY port";
        $result = mysql_query($sql);
        $count=0;
        $live=0;
        while($row = mysql_fetch_array($result)){
                $sub_sql="SELECT svc_status,timestamp from hosts_service_log where port='$row[1]' and host_id='$row[0]' order by record_id DESC LIMIT 1";
                $sub_result = mysql_query($sub_sql);
                $sub_row = mysql_fetch_array($sub_result);

                if($row[0]>0){
                        $status=$sub_row[0];
                        if($status==1){$live++;}
                        $count++;
                }
        }
        return array($live,$count);
}

function get_snmp_status($hostname){

		global $SNMP;
		
		$sql="select a.host_id from hosts_nw_snmp a,hosts_master b where a.host_id=b.host_id and enabled='1' and b.hostname='$hostname'";
		$result = mysql_query($sql);
		$enabled = mysql_num_rows($result);

		if($SNMP == 1 && $enabled == 1){
		$sql = "SELECT a.host_id,b.nw_snmp_cpu_status,b.nw_snmp_mem_status,b.cpu_user,b.cpu_system,b.cpu_idle,b.timestamp,b.mem_utilization,b.nw_snmp_dsk_status,b.disk_utilization FROM hosts_master a,hosts_nw_snmp_log b WHERE a.host_id=b.host_id AND a.hostname='$hostname' ORDER BY b.record_id DESC LIMIT 1";
		$result = mysql_query($sql);
		$snmp_data_count = mysql_num_rows($result);
		
		while ($row = mysql_fetch_object($result)){					
			$network_snmp_cpu_status=$row->nw_snmp_cpu_status;
			$network_snmp_cpu_usage = $row->cpu_user + $row->cpu_system;

			$network_snmp_mem_status=$row->nw_snmp_mem_status;
			$network_snmp_mem_usage = $row->mem_utilization;
			
			$network_snmp_dsk_status=$row->nw_snmp_dsk_status; // 1=OK,0=CHECK,-1=NA
			$network_snmp_dsk_usage = $row->disk_utilization;
		}

		if ($snmp_data_count > 0){
			if ($network_snmp_cpu_usage >= 0){
				$cpu=$network_snmp_cpu_usage;
			}elseif($network_snmp_cpu_usage < 0){
				$cpu="999";
			}else{
				$cpu="111";
			}
			// 999=NR, 111=NA

			if ($network_snmp_mem_usage >= 0){
				$mem=$network_snmp_mem_usage;
			}elseif($network_snmp_mem_usage >= 0){
				$mem="999";
			}else{
				$mem="111";
			}
			// 999=NR, 111=NA
						
			//$network_snmp_dsk_usage=str_replace("</br>","\n",$network_snmp_dsk_usage);
			//First variable indicates SNMP data is available
			return array(1,$network_snmp_cpu_status,$cpu,$network_snmp_mem_status,$mem,$network_snmp_dsk_status,$network_snmp_dsk_usage);
			
		}else{
			//First variable indicates SNMP data is not available
			return array(0,"NA","NA","NA","NA","NA","NA");
		}
	}
}
?>