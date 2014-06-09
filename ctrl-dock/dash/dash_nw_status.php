<?
include_once("include/config.php");
include_once("include/system_config.php");
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
<table class="reporttable" width=100% cellspacing=0 cellpadding=5 onclick="window.location='dash/dash_see_more_hosts.php'">
<tr>	
<?
	// Fetch Network Status Summary
	$sql = "SELECT a.host_id FROM hosts_nw a, hosts_master b WHERE enabled='1' AND b.status='1' AND a.host_id=b.host_id ORDER BY host_id";
	$result = mysql_query($sql);
	$up_status	=0;
	$total		=0;
	while($row = mysql_fetch_array($result)){
		$sub_sql	="SELECT nw_status FROM hosts_nw_log WHERE host_id='$row[0]' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);	
		$sub_row 	= mysql_fetch_array($sub_result);
		$status		= $sub_row[0];	
		if($status==1){
			$up_status++;
		}
		$total++;
	}
	
	$bg_color="#CC0000";
	if ($up_status == $total){$bg_color="#3A8C04";}
	$code_tabs[0]=$bg_color;
	echo "<td width=33% height=100 style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>NETWORK</b><br><br>";
	echo "<font size=6><b>$up_status / $total</b></td>";
	
	
	
	// Fetch Service Status Summary
	$sql = "SELECT a.host_id,a.port FROM hosts_service a, hosts_master b WHERE enabled='1' AND b.status='1' AND a.host_id=b.host_id ORDER BY host_id";
	$result = mysql_query($sql);
	
	$up_status	=0;
	$total		=0;
	
	while($row = mysql_fetch_array($result)){
		$host_id	=$row[0];
		$port		=$row[1];
				
		$sub_sql	="SELECT svc_status FROM hosts_service_log WHERE host_id='$host_id' and port='$port' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);
		$sub_row 	= mysql_fetch_array($sub_result);
		$status		= $sub_row[0];
		if($status==1){
			$up_status++;
		}
		$total++;
	}
	$bg_color="#CC0000";
	if ($up_status == $total){$bg_color="#3A8C04";}
	$code_tabs[1]=$bg_color;
	echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>SERVICES</b><br><br>";
	echo "<font size=6><b>$up_status / $total</b></td>";
	
		
	
	// Fetch Performance Status Summary
	$sql = "select a.host_id from hosts_nw_snmp a,hosts_master b where a.enabled='1' AND b.status='1' AND a.host_id=b.host_id";
	$result = mysql_query($sql);
	
	$up_status	=0;
	$total		=0;
	while($row = mysql_fetch_array($result)){
		$host_id	=$row[0];
		$sub_sql	="SELECT nw_snmp_cpu_status,nw_snmp_mem_status,nw_snmp_dsk_status FROM hosts_nw_snmp_log WHERE host_id='$host_id' ORDER BY record_id DESC LIMIT 1";				
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_array($sub_result);
		
		if ($sub_row[0]==1){$up_status++;}$total++;
		if ($sub_row[1]==1){$up_status++;}$total++;
		if ($sub_row[2]==1){$up_status++;}$total++;
	}
	$bg_color="#CC0000";
	if ($up_status == $total){$bg_color="#3A8C04";}
	$code_tabs[2]=$bg_color;
	echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>PERFORMANCE</b><br><br>";
	echo "<font size=6><b>$up_status / $total</b></td>";	
?>
</tr>
<?
echo "<tr>";
for ($i=0;$i<count($code_tabs);$i++){
	$bgcolor=$code_tabs[$i];
	echo "<td style='text-align: center; background-color: $bgcolor;' height=8px></td>";
}
echo "</tr>";
?>
</table>