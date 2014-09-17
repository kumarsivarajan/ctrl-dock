<?include("config.php"); ?>
<?
$SELECTED="HOST MONITORING";
include("header.php");


$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;
$username=$_SESSION['username'];


?>
<center>
<br>
<table class="reporttable" width=100% cellspacing=1 cellpadding=6>
<tr>
	<td class="reportheader">Hostname</td>
	<td class="reportheader">Description</td>
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
			
			echo "<tr bgcolor=#EEEEEE onClick=\"document.location='../nw/show_host_details.php?hostname=$hostname&desc=$description&txttime=6'\">";
			echo "<td class='reportdata'>".$hostname."</td>";
			echo "<td class='reportdata'>".$description."</td>";
			echo "<td class='reportdata' style='text-align: center;'>".$platform."</td>";
			
			$network=get_nw_status($hostname);

			if ($network==1){$bgcolor="#65C60D";$text="UP";}
			if ($network==0){$bgcolor="#FF0000";$text="DOWN";}
			if ($network==11){$bgcolor="#A9A9A9";$text="NA";}
			echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$text."</td>";
			
			
			list($live,$count)=get_svc_status($hostname);
			if ($live==$count){$bgcolor="#65C60D";}
			if ($live<$count){$bgcolor="#FF0000";}
			if($live == 0 && $count == 0){$bgcolor="#A9A9A9";}
			echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$live."/".$count."</td>";
			
			list($snmp,$network_snmp_cpu_status,$cpu,$network_snmp_mem_status,$mem,$network_snmp_dsk_status,$network_snmp_dsk_usage)=get_snmp_status($hostname);
			

			if($snmp == 1){
				
				if ($cpu>0 && $cpu<=100){
						if ($network_snmp_cpu_status==1){$bgcolor="#65C60D";}
						if ($network_snmp_cpu_status==0){$bgcolor="#FF0000";}
						$cpu_text=$cpu."%";
				}
				if ($cpu==999)	{$bgcolor="#FFD800";$cpu_text="NR";}
				if ($cpu==111)	{$bgcolor="#A9A9A9";$cpu_text="NA";}
				
				echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$cpu_text."</td>";

				
				if ($mem>0 && $mem<=100){
						if ($network_snmp_mem_status==1){$bgcolor="#65C60D";}
						if ($network_snmp_mem_status==0){$bgcolor="#FF0000";}
						$mem_text=$mem."%";
				}
				if ($mem==999)	{$bgcolor="#FFD800";$mem_text="NR";}
				if ($mem==111)	{$bgcolor="#A9A9A9";$mem_text="NA";}
				echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80>".$mem_text."</td>";
					

				
				if ($network_snmp_dsk_status==1)  {$bgcolor="#65C60D";$dsk_text="OK";}
				if ($network_snmp_dsk_status==0)  {$bgcolor="#FF0000";$dsk_text="CHECK";}
				if ($network_snmp_dsk_status==-1) {$bgcolor="#A9A9A9"; $network_snmp_dsk_usage="NA";}
				$network_snmp_dsk_usage=str_replace("</br>","\n",$network_snmp_dsk_usage);
				echo "<td class='reportdata' style='text-align: center;background-color: $bgcolor;' width=80 title='$network_snmp_dsk_usage'>$dsk_text</td>";
				
			}
			if($snmp == 0){
				echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
				echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
				echo "<td class='reportdata' style='text-align: center;background-color: #A9A9A9;' width=80>NA</td>";
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