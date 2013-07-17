<? include_once("../auth.php");
session_start();
include_once("../include/config.php");
include_once("../include/system_config.php");
include_once("../include/css/default.css");
include_once("../include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;
$username=$_SESSION['username'];


?>
<center>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5 >
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>HOST MONITORING</b></font>
	</td>
	<td width=10% class='reportdata' style='text-align:right;'>
		<a href=../dash.php>BACK</a>
	</td>
	</tr>
</table>
<br>
<table class="reporttable" width=100% cellspacing=1 cellpadding=6>
<tr>	
	<td class="reportheader">Description</td>
	<td class="reportheader">Hostname</td>
	<td class="reportheader">Platform</td>
	<td class="reportheader" width=100>Network</td>
	<td class="reportheader" width=100>Services</td>	
	<?php if($SNMP == 1){ ?>	
	<td class="reportheader" width=100>CPU</td>
	<td class="reportheader" width=100>Memory</td>
	<td class="reportheader" colspan=2 width=100>Disk</td>
	<?php } ?>
</tr>
<?
$url=$base_url."/api/hosts_list.php?key=$API_KEY";
$host_list = load_xml($url);

if(count($host_list)>0){
	for($i=0;$i<count($host_list);$i++){		
			$hostname=$host_list->host[$i]->hostname;
			
			if(strlen($hostname)>0){
			$platform=$host_list->host[$i]->platform;
			$description=$host_list->host[$i]->description;
			
			$url=$base_url."/api/hosts_nw_status.php?key=$API_KEY&hostname=".$hostname;
			$nw_status = load_xml($url);
			$network=$nw_status->status[0]->nw_status;
			if (strlen($network)==0){$network=11;}
			
			if($SNMP == 1){
			$url=$base_url."/api/hosts_nw_snmp_status.php?key=$API_KEY&hostname=".$hostname;
			$nw_snmp_status = load_xml($url);
			$snmp_data_count = $nw_snmp_status->count[0];
			$network_snmp_cpu_status=$nw_snmp_status->status[0]->nw_snmp_cpu_status;
			$network_snmp_mem_status=$nw_snmp_status->status[0]->nw_snmp_mem_status;
			$network_snmp_dsk_status=$nw_snmp_status->status[0]->nw_snmp_dsk_status;
			$network_snmp_cpu_usage = $nw_snmp_status->status[0]->cpu_user + $nw_snmp_status->status[0]->cpu_system;
			$network_snmp_mem_usage = $nw_snmp_status->status[0]->mem_utilization;
			$network_snmp_dsk_usage = $nw_snmp_status->status[0]->disk_utilization;
			}
			
			$url=$base_url."/api/hosts_svc_status.php?key=$API_KEY&hostname=".$hostname;
			$services = load_xml($url);
			$count=0;
			$live=0;
			for($j=0;$j<count($services);$j++){
				$host_id=$services->status[$j]->host_id;
				if($host_id>0){
					$status=$services->status[$j]->svc_status;
					if($status==1){$live++;}
					$count++;
				}
			}
			
			echo "<tr bgcolor=#EEEEEE onClick=\"document.location='../nw/show_host_details.php?hostname=$hostname&desc=$description&txttime=6'\">";
			echo "<td class='reportdata'>".$description."</td>";
			echo "<td class='reportdata'>".$hostname."</td>";
			echo "<td class='reportdata' style='text-align: center;'>".$platform."</td>";
			
			/*$_SESSION['hostname'] == '$hostname';
			echo "<pre>";
			print_r($_SESSION['hostname']);*/
			
			if ($network==1){$bgcolor="#65C60D";$text="UP";}
			if ($network==0){$bgcolor="#FF0000";$text="DOWN";}
			if ($network==11){$bgcolor="#A9A9A9";$text="NA";}
			echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$text."</td>";
				if ($live==$count){$bgcolor="#65C60D";}
				if ($live<$count){$bgcolor="#FF0000";}
			if($live == 0 && $count == 0)
			{
				$bgcolor="#A9A9A9";
			}
			echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$live."/".$count."</td>";
			
			if($SNMP == 1){
				if ($snmp_data_count == ""){
					if ($network_snmp_cpu_status==1){$bgcolor="#65C60D";}
					if ($network_snmp_cpu_status==0){$bgcolor="#FF0000";}
					if ($network_snmp_cpu_usage >= 0){
						echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$network_snmp_cpu_usage."%</td>";
					}elseif($network_snmp_cpu_usage < 0){
						echo "<td class='reportdata' style='text-align: center;background-color: #FF0000;' width=80>NR</td>";
					}else{
						echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
					}
					

					if ($network_snmp_mem_status==1){$bgcolor="#65C60D";}
					if ($network_snmp_mem_status==0){$bgcolor="#FF0000";}
					if ($network_snmp_mem_usage >= 0){
						echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$network_snmp_mem_usage."%</td>";
					}elseif($network_snmp_mem_usage >= 0){
						echo "<td class='reportdata' style='text-align: center;background-color: #FF0000;' width=80>NR</td>";
					}else{
						echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
					}
					
					if ($network_snmp_dsk_status==1){$bgcolor="#65C60D";$dsk_text="OK";}
					if ($network_snmp_dsk_status==0){$bgcolor="#FF0000";$dsk_text="CHECK";}
					if ($network_snmp_dsk_status==-1) {$bgcolor="#A9A9A9"; $network_snmp_dsk_usage="NA";}
					$network_snmp_dsk_usage=str_replace("</br>","\n",$network_snmp_dsk_usage);
					echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80 title='$network_snmp_dsk_usage'>$dsk_text</td>";
				}else{
					echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
					echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
					echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
				}
			}
			echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=20>
			<a href='../nw/show_host_details.php?hostname=$hostname&desc=$description&txttime=6'><img border=0 src='../images/history.gif'></a></td>";
			echo "</tr>";
		}
	}
}
?>
	</td>
</tr>
<tr>
	<td class='reportdata' colspan=9>
		NA : Not Available / Applicable&nbsp;&nbsp;NR : Not Reporting
	</td>
</tr>
</table>
<meta http-equiv="refresh" content="300">