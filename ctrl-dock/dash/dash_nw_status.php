<?
include_once("include/config.php");
include_once("include/system_config.php");
include_once("include/host_nw.php");
include_once("include/css/default.css");
include_once("include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;
$code_tabs=array();
?>


<table border=0 width=100% cellspacing=0 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>HOSTS</td>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5 onclick="window.location='../nw/index.php'">

<?
$network_count		=0;
$network_count_up	=0;

$svc_live			=0;
$svc_count			=0;

$snmp_count			=0;
$snmp_perf			=0;

$url=$base_url."/api/hosts_list.php?key=$API_KEY";
$host_list = load_xml($url);

if(count($host_list)>0){
	for($i=0;$i<count($host_list);$i++){		
			$hostname=$host_list->host[$i]->hostname;
			
			if(strlen($hostname)>0){
			$platform=$host_list->host[$i]->platform;
			$description=$host_list->host[$i]->description;
						
			$network=get_nw_status($hostname);

			if ($network==1){$network_count++;$network_count_up++;}
			if ($network==0){$network_count++;}
			//if ($network==11){$network_count++;}
			
			
			list($live,$count)=get_svc_status($hostname,$base_url,$API_KEY);
			
			$svc_live=$svc_live+$live;
			$svc_count=$svc_count+$count;
			
			
			list($snmp,$network_snmp_cpu_status,$cpu,$network_snmp_mem_status,$mem,$network_snmp_dsk_status,$network_snmp_dsk_usage)=get_snmp_status($hostname);
			

			if($snmp == 1){
				$snmp_count=$snmp_count+3;
				
				if ($network_snmp_cpu_status==1){$snmp_perf++;}
				if ($network_snmp_mem_status==1){$snmp_perf++;}
				if ($network_snmp_dsk_status==1){$snmp_perf++;}
			}
		}
	}
}
echo "<tr>";
echo "<td width=33% height=80 style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#666666'>";
echo "<b>NETWORK</b><br><br>";
echo "<font style='font-size:30px'><b>$network_count_up / $network_count</b></td>";

echo "<td width=33% height=80 style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#666666'>";
echo "<b>SERVICES</b><br><br>";
echo "<font style='font-size:30px'><b>$svc_live / $svc_count </b></td>";

echo "<td width=33% height=80 style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#666666'>";
echo "<b>PERFORMANCE</b><br><br>";
echo "<font style='font-size:30px'><b>$snmp_perf / $snmp_count </b></td>";

echo "</tr>";
echo "<tr>";

$bg_color="#CC0000";
if ($network_count_up == $network_count){$bg_color="#3A8C04";}
$code_tabs[0]=$bg_color;

$bg_color="#CC0000";
if ($svc_live == $svc_count){$bg_color="#3A8C04";}
$code_tabs[1]=$bg_color;

$bg_color="#CC0000";
if ($snmp_perf == $snmp_count){$bg_color="#3A8C04";}
$code_tabs[2]=$bg_color;

echo "<tr>";
for ($i=0;$i<count($code_tabs);$i++){
	$bgcolor=$code_tabs[$i];
	echo "<td style='text-align: center; background-color: $bgcolor;' height=8px></td>";
}
echo "</tr>";
?>
</table>
<meta http-equiv="refresh" content="300">