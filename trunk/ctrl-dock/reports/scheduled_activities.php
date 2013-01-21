<?
	$url=$base_url."/api/tkt_list_by_helptopics.php?key=$API_KEY&topic=Scheduled Activity&status=all&start_date=$start_date&end_date=$end_date";
	$query = load_xml("$url");
?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Scheduled Activities</td>
</tr>
</table>

<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class="reportheader" width=200>Date</td>
	<td class="reportheader" width=300>Activity</td>
	<td class="reportheader">Comments</td>
</td>
</tr>
<?
$current_count=0;
for($i=0;$i<count($query);$i++){
		echo "<tr bgcolor=#F0F0F0>";		
		echo "<td class='reportdata' style='text-align: left;'>".$query->ticket[$i]->created."</td>";
		echo "<td class='reportdata' style='text-align: left;'>".$query->ticket[$i]->subject."</td>";
		$note=str_replace('||',"<br>",$query->ticket[$i]->note);
		echo "<td class='reportdata' style='text-align: left;'>".$note."</td>";
		
		echo "</tr>";	
}

?>
</table>
