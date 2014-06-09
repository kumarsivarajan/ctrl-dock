<?
$url=$base_url."/api/tkt_count_by_staff_new.php?key=$API_KEY&start_date=$start_date&end_date=$end_date";
$current = load_xml($url);
?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Ticket Assignment By Staff</td>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>	
	<td class="reportheader">Staff Name</td>
	<td class="reportheader" width=80>Open Tickets</td>
	<td class="reportheader" width=100>Tickets Closed On-site</td>
	<td class="reportheader" width=100>Tickets Closed Remotely</td>
	<td class="reportheader" width=80>Count</td>
	<td class="reportheader" width=100>Avg. Response Time</td>
	<td class="reportheader" width=100>Avg. Closure Time</td>
	<td class="reportheader" width=80>SLA Non-Compliance</td>
	<td class="reportheader" width=80>Avg. Staff Rating</td>
	<td class="reportheader" width=50>Time Spent</td>
</td>
</tr>
<?
$current_count_staff=0;
$current_openticket_staff=0;
$current_sla_breached_staff=0;
$current_closeticket_local=0;
$current_closeticket_remote=0;
$time_spent=0;
$current_time_spent=0;

for($i=0;$i<count($current);$i++){
		//if ($current->ticketcount[$i]->total_count != "0" && ){ //Giri: Uncomment this check if needed
		if (true){
			echo "<tr bgcolor=#F0F0F0>";
			echo "<td class='reportdata'>".$current->ticketcount[$i]->staff."</td>";
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->open_count."</td>";
                        echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->close_locally_count."</td>";
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->close_remote_count."</td>";				echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->total_count."</td>";
			$avg_response=$current->ticketcount[$i]->avg_response_time;
			if($avg_response>0){
				$avg_response=$avg_response." Hrs";
			}else{
				$avg_response="NA";
			}
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$avg_response."</td>";
			$avg_closure=$current->ticketcount[$i]->avg_closure_time;
			if($avg_closure>0){
				$avg_closure=$avg_closure." Hrs";
			}else{
				$avg_closure="NA";
			}
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$avg_closure."</td>";
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->sla_breached_count."</td>";
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$current->ticketcount[$i]->rating."</td>";
			
			$time_spent=$current->ticketcount[$i]->time_spent;
			if ($time_spent<3600){$time_spent=round($time_spent/60,2) . " mins";}
			if ($time_spent>3600){$time_spent=round($time_spent/3600,2);$time_spent=$time_spent . " Hrs";}
			
			
			echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$time_spent."</td>";

			echo "</tr>";
			
			$current_count_staff=$current_count_staff+$current->ticketcount[$i]->total_count;
			$current_openticket_staff=$current_openticket_staff+$current->ticketcount[$i]->open_count;
			$current_sla_breached_staff=$current_sla_breached_staff+$current->ticketcount[$i]->sla_breached_count;
			$current_closeticket_local=$current_closeticket_local+$current->ticketcount[$i]->close_locally_count;
			$current_closeticket_remote=$current_closeticket_remote+$current->ticketcount[$i]->close_remote_count;
			$current_time_spent=$current_time_spent+$current->ticketcount[$i]->time_spent;
	}
}
$time_spent=$current_time_spent;
if ($time_spent<3600){$time_spent=round($time_spent/60,2) . " mins";}
if ($time_spent>3600){$time_spent=round($time_spent/3600,2);$time_spent=$time_spent . " Hrs";}

?>
<tr>	
	<td class="reportheader" style='text-align: right'>TOTAL&nbsp;</td>
	<td class="reportheader"><?=$current_openticket_staff;?></td> 
	<td class="reportheader"><?=$current_closeticket_local;?></td>
	<td class="reportheader"><?=$current_closeticket_remote;?></td>
	<td class="reportheader"><?=$current_count_staff;?></td>	<!-- GIRI - NASTY CODING - PLEASE CROSS-VERIFY AND CHANGE!!!-->
	<td class="reportheader"></td>
	<td class="reportheader"></td>
	<td class="reportheader"><?=$current_sla_breached;?></td>
	<td class="reportheader"></td>
	<td class="reportheader"><?=$time_spent;?></td>
	
	
</tr>
</table>
