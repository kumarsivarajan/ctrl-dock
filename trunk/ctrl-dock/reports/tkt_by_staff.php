<?
$url=$base_url."/api/tkt_count_by_staff.php?key=$API_KEY&start_date=$start_date&end_date=$end_date";
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
	<td class="reportheader" width=100>Percentage</td>	
</td>
</tr>
<?
$total_count=0;
for($i=0;$i<count($current);$i++){
		$total_count=$total_count+$current->ticketcount[$i]->count;
}
for($i=0;$i<count($current);$i++){
		echo "<tr bgcolor=#F0F0F0>";
		echo "<td class='reportdata'>".$current->ticketcount[$i]->staff."</td>";
		$percentage=($current->ticketcount[$i]->count/$total_count)*100;
		$percentage=round($percentage,1);
		echo "<td class='reportdata' style='text-align:center;background-color:#CCCCFF'>".$percentage." %</td>";		
		echo "</tr>";
}

?>
</table>
