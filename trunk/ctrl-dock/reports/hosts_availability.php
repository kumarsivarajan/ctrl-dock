<?
$url=$base_url."/api/hosts_list.php?key=$API_KEY";
$host_list = load_xml($url);
?>

<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Hosts / Service Availability</td>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=1 cellpadding=4>
<tr>	
	<td class="reportheader">Description</td>
	<td class="reportheader">Hostname</td>
	<td class="reportheader">Platform</td>
	<td class="reportheader">Network Uptime</td>	
	<td class="reportheader">Network Downtime</td>	
	<td class="reportheader">Service Uptime</td>	
	<td class="reportheader">Service Downtime</td>
	<td class="reportheader">Service Information</td>		

</tr>
<?
if(count($host_list)>0){
	for($i=0;$i<count($host_list);$i++){		
			$hostname=$host_list->host[$i]->hostname;
			if(strlen($hostname)>0){
			$platform=$host_list->host[$i]->platform;
			$description=$host_list->host[$i]->description;
			$graphdescription[]=$description;
		
			echo "<tr bgcolor=#EEEEEE>";
			echo "<td class='reportdata'>".$description."</td>";
			echo "<td class='reportdata'>".$hostname."</td>";
			echo "<td class='reportdata' style='text-align: center;'>".$platform."</td>";
			
			$url=$base_url."/api/hosts_availability.php?key=$API_KEY&hostname=$hostname&start_date=$start_date&end_date=$end_date";		
			$host_availability = load_xml($url);
			
			$uptime=$host_availability->availability[0]->uptime;
			$graphuptime[]=$uptime;
			echo "<td class='reportdata' style='text-align: center;'>".$uptime." %</td>";
			$downtime=$host_availability->availability[0]->downtime;
			
			
			$downtime_hrs=$host_availability->availability[0]->downtime_hrs;
			$graphdowntime[]=$downtime_hrs;
			
			echo "<td class='reportdata' style='text-align: center;'>".$downtime_hrs." Hrs</td>";
			
			$url=$base_url."/api/hosts_svc_availability.php?key=$API_KEY&hostname=$hostname&start_date=$start_date&end_date=$end_date";	
			$host_availability = load_xml($url);
			
			$uptime=$host_availability->availability[0]->uptime;
			echo "<td class='reportdata' style='text-align: center;'>".$uptime." %</td>";
			$downtime=$host_availability->availability[0]->downtime;
			echo "<td class='reportdata' style='text-align: center;'>".$downtime." %</td>";
			
			
			
			// Display Service Information
			
			echo "<td colspan=1 class='reportdata'>";
			$url=$base_url."/api/hosts_svc_availability_info.php?key=$API_KEY&hostname=$hostname&start_date=$start_date&end_date=$end_date";	
			$service_list = load_xml($url);
			if(count($service_list)>0){
				for($j=0;$j<count($service_list);$j++){					
					echo $service_list->service_info[$j]->description ." (". $service_list->service_info[$j]->port. ") ".$service_list->service_info[$j]->uptime . "%<br>";
				}
			}
			
			echo "</td></tr>";
			
		}
	}
}
echo "</table>";

?>
