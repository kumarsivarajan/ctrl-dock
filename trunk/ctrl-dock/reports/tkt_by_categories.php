<?
$url=$base_url."/api/tkt_count_by_helptopics.php?key=$API_KEY&status=all&start_date=$start_date&end_date=$end_date";
$current = load_xml($url);
?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Ticket Summary : Category</td>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>	
	<td class="reportheader">Category</td>
	<td class="reportheader" width=100>No. of Open Tickets</td>
	<td class="reportheader" width=100>Count</td>
	<td class="reportheader" width=100>Avg. Response Time</td>
	<td class="reportheader" width=100>Avg. Closure Time</td>
	<td class="reportheader" width=100>SLA<br>Non-Compliance</td>
</td>
</tr>

<?

$current_count=0;
$current_openticket=0;
$current_sla_breached=0;
$row_count=0;
for($i=0;$i<count($current);$i++){
	$check_value=$current->helptopic[$i]->count;
	if($check_value>0){
		echo "<tr bgcolor=#F0F0F0>";
		echo "<td class='reportdata'>".$current->helptopic[$i]->topic."</td>";
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->helptopic[$i]->open_ticket."</td>";
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->helptopic[$i]->count."</td>";
		$avg_response=$current->helptopic[$i]->avg_response;
		if($avg_response>0){
			$avg_response=$avg_response." Hrs";
		}else{
			$avg_response="NA";
		}
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$avg_response."</td>";		
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->helptopic[$i]->avg_closure." Hrs</td>";		
		echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'>".$current->helptopic[$i]->sla_breached."</td>";		
		echo "</tr>";
		$current_count=$current_count+$current->helptopic[$i]->count;
		$current_openticket=$current_openticket+$current->helptopic[$i]->open_ticket;
		$current_sla_breached=$current_sla_breached+$current->helptopic[$i]->sla_breached;
	}
}

?>

<tr>	
	<td class="reportheader" style='text-align: right'>TOTAL&nbsp;</td>
	<td class="reportheader"><?echo $current_openticket;?></td>
	<td class="reportheader"><?echo $current_count;?></td>	
	<td class="reportheader"></td>
	<td class="reportheader"></td>
	<td class="reportheader"><?echo $current_sla_breached;?></td>
</tr>

<tr>
		<tr bgcolor=#FFFFFF>
		<td class='reportdata'>Ticket categories which have no tickets logged against them during the selected date range have been excluded.</td>
</tr>
</table>