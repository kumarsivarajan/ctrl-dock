<?
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/mail.php");
include_once("../include/mail_helper.php");
include_once("../include/ticket_post.php");

$sql="SELECT timeservers, diffthreshold from hosts_timesync_config "; //Technically there should be only one row.
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)){
	$servers		= $row['timeservers'];
	$threshold		= $row['diffthreshold'];
	
	// If there are no or zero values, then exit;
	if ($servers == '' or (int)$threshold < 1){
		exit;
	}
	
	// Remove all the whitespaces
	$servers = preg_replace('/\s+/', '', $servers);
	$servers = explode (',', $servers);
	
	
	//Start of Host loop - This will be based on SNMP
	$snmpsql="SELECT a.hostname,a.timezone,b.retry_count,b.timeout,b.community_string,a.platform,b.port,b.version,b.v3_user,b.v3_pwd FROM hosts_master a,hosts_nw_snmp b WHERE a.host_id=b.host_id AND a.status='1' AND b.enabled='1' ORDER BY a.hostname";
	$snmpresult = mysql_query($snmpsql);
	while ($snmprow = mysql_fetch_assoc($snmpresult)){
		$hostname		=	$snmprow['hostname'].":".$snmprow['port'];
		$count			=	$snmprow['retry_count'];if($count==""){$count=4;}
		$timeout		=	$snmprow['timeout'];if($timeout==""){$timeout=5;}
		$community_string = $snmprow['community_string'];if($community_string==""){$community_string="public";}
		$platform		=	$snmprow['platform'];if($platform==""){$platform="LINUX";}
		$snmp_version		=	$snmprow['version']; if ($snmp_version==''){$snmp_version='v2';}
		$v3_user			=	$snmprow['v3_user'];
		$v3_pwd				=	$snmprow['v3_pwd'];
		$snmplocal_sent = microtime(true);
		$timezone			= $snmprow['timezone'];
		$timezone			= number_format((float)$timezone,1,'.','');
		$tzDelta 			= ($timezone * 3600 * 1000);
		
		$timeMIB = 'hrSystemDate.0';
		snmp_set_quick_print(1);
		$timeInfo='';
		$snmpTime='';
		if (strtolower($snmp_version) == 'v3') { //SNMP V3 is used
			$timeInfo = @snmp3_get($hostname, $v3_user, "authNoPriv", "MD5", $v3_pwd, "DES", "", $timeMIB, $timeout, $count);
		}else{
			$timeInfo = @snmpget($hostname, $community_string, $timeMIB, $timeout, $count);
		}
		$regex="/^(?P<YYYY>\d\d\d\d)-(?P<MM>\d+)-(?P<DD>\d+),(?P<HH>\d+):(?P<mm>\d+):(?P<ss>\d+)\.(?P<millisec>\d+),(?P<plusminus>[+-])(?P<TZHH>\d+):(?P<TZMM>\d+)$/";
		preg_match($regex, $timeInfo,$matches);	
		$snmpTime = $matches['YYYY'] . '-' . sprintf("%02s",$matches['MM']) . '-' . sprintf("%02s",$matches['DD']) . ' ' . sprintf("%02s",$matches['HH']) . ':' . sprintf("%02s",$matches['mm']) . ':' . sprintf("%02s",$matches['ss']);
		$snmpTime = strtotime($snmpTime);
		$server_time_formatted = date('Y-m-d H:i:s',$snmpTime);
		$snmpTime = round(($snmpTime * 1000) + ($matches['millisec'] * 1000)); // Time from microsec in ms
		
		/* Following code was for linux snmp reads.
		//Now convert to UTC
		$tzDelta = (($matches['TZHH']*3600) + ($matches['TZMM'] * 60))*1000;
		if ($matches['plusminus'] == '+'){ //Ahead... so subtract to get UTC time
			$snmpTime = $snmpTime - $tzDelta;
		}else{	//Behind... so add to get UTC time
			$snmpTime = $snmpTime + $tzDelta;
		}
		*/
		// if tzDelta is > 0, then the time is ahead; subtract delta to get UTC.
		// if tzDelta is < 0, then the time is behind; add to get UTC
		$snmpTime = $snmpTime - $tzDelta;
		$snmplocal_received = microtime(true);
		$snmpDelay = round((($snmplocal_received - $snmplocal_received)/2)); // in ms
		$actualSnmpTime = $snmpTime + $snmpDelay;
		
		$ntp_time =  getNTPTime($servers);
		$ntp_time_explode = explode('.',$ntp_time);
		//Convert to UTC as NTP time is always returned in server timezone
		$ntp_UTC_formatted = gmdate('Y-m-d H:i:s',strtotime((date('Y-m-d H:i:s', $ntp_time_explode[0])))) . '.'.$ntp_time_explode[1];
		
		$pregex = "/^(?P<Y>\d\d\d\d)-(?P<m>\d\d)-(?P<d>\d\d)\s(?P<H>\d\d):(?P<i>\d\d):(?P<s>\d\d).(?P<microsec>\d+)$/";
		preg_match($pregex,$ntp_UTC_formatted,$ntp_matches);
		$ntp_UTC = mktime($ntp_matches['H'],$ntp_matches['i'],$ntp_matches['s'],$ntp_matches['m'],$ntp_matches['d'],$ntp_matches['Y']);
	
		$ntp_time_formatted = date('Y-m-d H:i:s', $ntp_time_explode[0]).'.'.$ntp_time_explode[1];
		$ntp_UTC = ($ntp_UTC * 1000);
		//compare with the current server time
		$overallDifference = $ntp_UTC - $actualSnmpTime;
		
		echo "NTP Server Time - $ntp_time_formatted; Server Time - $server_time_formatted; Difference(NTP-Server) - $overallDifference ms\n";
		if ($overallDifference >= (int)$threshold){
			$timestamp_human=date("d-M-Y H:i:s",$timestamp);
			$message  = "ALERT at $timestamp_human: Server time is out of sync ";
			$subject= "NTP Server Time - $ntp_time_formatted; Server Time - $server_time_formatted; Difference(NTP-Server) - $overallDifference ms";
			ticket_post($smtp_email,$smtp_email,"28","$subject","$message",'1');
		}
	}
}

function getNTPTime($servers){
	$bit_max = 4294967296;
	$epoch_convert = 2208988800;
	$vn = 3;
	$server_count = count($servers);
	//see rfc5905, page 20
	//first byte
	//LI (leap indicator), a 2-bit integer. 00 for 'no warning'
	$header = '00';
	//VN (version number), a 3-bit integer.  011 for version 3
	$header .= sprintf('%03d',decbin($vn));
	//Mode (association mode), a 3-bit integer. 011 for 'client'
	$header .= '011';
	
	//construct the packet header, byte 1
	$request_packet = chr(bindec($header));
	
	//we'll use a for loop to try additional servers should one fail to respond
	$i = 0;
	for($i; $i < $server_count; $i++) {
		$socket = @fsockopen('udp://'.$servers[$i], 123, $err_no, $err_str,1);
		if ($socket) {
			//add nulls to position 11 (the transmit timestamp, later to be returned as originate)
			//10 lots of 32 bits
			for ($j=1; $j<40; $j++) {
				$request_packet .= chr(0x0);
			}

			//the time our packet is sent from our server (returns a string in the form 'msec sec')
			$local_sent_explode = explode(' ',microtime());
			$local_sent = $local_sent_explode[1] + $local_sent_explode[0];

			//add 70 years to convert unix to ntp epoch
			$originate_seconds = $local_sent_explode[1] + $epoch_convert;

			//convert the float given by microtime to a fraction of 32 bits
			$originate_fractional = round($local_sent_explode[0] * $bit_max);

			//pad fractional seconds to 32-bit length
			$originate_fractional = sprintf('%010d',$originate_fractional);

			//pack to big endian binary string
			$packed_seconds = pack('N', $originate_seconds);
			$packed_fractional = pack("N", $originate_fractional);

			//add the packed transmit timestamp
			$request_packet .= $packed_seconds;
			$request_packet .= $packed_fractional;

			if (fwrite($socket, $request_packet)) {
				$data = NULL;
				stream_set_timeout($socket, 1);
				$response = fread($socket, 48);

				//the time the response was received
				$local_received = microtime(true);
			}
			fclose($socket);

			if (strlen($response) == 48) {
				//the response was of the right length, assume it's valid and break out of the loop
				break;
			}else{
				if ($i == $server_count-1) {
					//this was the last server on the list, so give up
					die('unable to establish a connection');
				}
			}
		}else{
			if ($i == $server_count-1) {
				//this was the last server on the list, so give up
				die('unable to establish a connection');
			}
		}
	}

	//unpack the response to unsigned long for calculations
	$unpack0 = unpack("N12", $response);
	//print_r($unpack0);

	//present as a decimal number
	$remote_originate_seconds = sprintf('%u', $unpack0[7])-$epoch_convert;
	$remote_received_seconds = sprintf('%u', $unpack0[9])-$epoch_convert;
	$remote_transmitted_seconds = sprintf('%u', $unpack0[11])-$epoch_convert;

	$remote_originate_fraction = sprintf('%u', $unpack0[8]) / $bit_max;
	$remote_received_fraction = sprintf('%u', $unpack0[10]) / $bit_max;
	$remote_transmitted_fraction = sprintf('%u', $unpack0[12]) / $bit_max;

	$remote_originate = $remote_originate_seconds + $remote_originate_fraction;
	$remote_received = $remote_received_seconds + $remote_received_fraction;
	$remote_transmitted = $remote_transmitted_seconds + $remote_transmitted_fraction;

	//unpack to ascii characters for the header response
	$unpack1 = unpack("C12", $response);
	//print_r($unpack1);

	//echo 'byte 1: ' . $unpack1[1] . ' | ';

	//the header response in binary (base 2)
	$header_response =  base_convert($unpack1[1], 10, 2);

	//pad with zeros to 1 byte (8 bits)
	$header_response = sprintf('%08d',$header_response);

	//Mode (the last 3 bits of the first byte), converting to decimal for humans;
	$mode_response = bindec(substr($header_response, -3));

	//VN
	$vn_response = bindec(substr($header_response, -6, 3));

	//the header stratum response in binary (base 2)
	$stratum_response =  base_convert($unpack1[2], 10, 2);
	$stratum_response = bindec($stratum_response);

	//calculations assume a symmetrical delay, fixed point would give more accuracy
	$delay = (($local_received - $local_sent) / 2)  - ($remote_transmitted - $remote_received);
	$delay_ms = round($delay * 1000) . ' ms';

	$server = $servers[$i];
	$ntp_time =  $remote_transmitted - $delay;
	return $ntp_time;
}
?>
