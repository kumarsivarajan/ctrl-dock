<?
$url=$base_url."/api/tkt_count_by_priority.php?key=$API_KEY&status=all&start_date=$start_date&end_date=$end_date";
$current = load_xml($url);
?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Ticket Summary : Priority</td>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>	
	<td class="reportheader">Priority</td>
	<td class="reportheader" width=100>No. of Open Tickets</td>
	<td class="reportheader" width=100>Count</td>
	<td class="reportheader" width=100>Avg. Response Time</td>
	<td class="reportheader" width=100>Avg. Closure Time</td>
	<td class="reportheader" width=100>SLA<br>Non-Compliance</td>
</td>
</tr>
<?
$current_count=0;
$opened = 0;
$sla_tot = 0;
for($i=0;$i<count($current);$i++){
		echo "<tr bgcolor=#F0F0F0>";
		echo "<td class='reportdata'>".$current->ticketpriority[$i]->priority."</td>";
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->ticketpriority[$i]->open_tickets_total."</td>";
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->ticketpriority[$i]->count."</td>";
		
		$avg_response=$current->ticketpriority[$i]->avg_response;
		if($avg_response>0){
			$avg_response=$avg_response." Hrs";
		}else{
			$avg_response="NA";
		}
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$avg_response."</td>";		
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->ticketpriority[$i]->avg_closure." Hrs</td>";
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->ticketpriority[$i]->sla."</td>";
		echo "</tr>";
		$current_count=$current_count+$current->ticketpriority[$i]->count;
		$opened = $opened+$current->ticketpriority[$i]->open_tickets_total;
		$sla_tot = $sla_tot+$current->ticketpriority[$i]->sla;
}

?>
<tr>	
	<td class="reportheader" style='text-align: right'>TOTAL</td>
	<td class="reportheader"><?php echo $opened; ?></td>
	<td class="reportheader"><?php echo $current_count;?></td>
	<td class="reportheader"></td>
	<td class="reportheader"></td>
	<td class="reportheader"><?php echo $sla_tot;?></td>
</tr>
</table>
