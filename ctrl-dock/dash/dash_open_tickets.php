<?
include_once("include/config.php");
include_once("include/css/default.css");
include_once("include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

// To display list of open tickets

?>

<table border=0 width=100% cellspacing=0 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>TICKETS</td>
</tr>
</table>

<table cellspacing=1 cellpadding=0 border=0 width=100%>
<tr>
<td width=50%>
		<table class="reporttable" style="border: 0px;" width=100% height=250px cellspacing=0 cellpadding=0>
		<?
		$url=$base_url."/api/tkt_count_summary.php?key=$API_KEY&staff=$username";
		if ($query = load_xml($url)){
			for($i=0;$i<count($query);$i++){
				$open=$query->summary[$i]->open;
				$low=$query->summary[$i]->low;
				$normal=$query->summary[$i]->normal;
				$high=$query->summary[$i]->high;
				$emergency=$query->summary[$i]->emergency;
				$exception=$query->summary[$i]->exception;
				$staff=$query->summary[$i]->staff;
				$unassigned=$query->summary[$i]->unassigned;
			}

			echo "<tr>";
			$code_tabs=array();
			
			$bg_color="#999999";
			if($staff>0){$bg_color="#89B700";}
			$code_tabs[0]=$bg_color;
			echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?status=assigned'\">";
			echo "<b>MY TICKETS</b><br><br>";
			echo "<font style='font-size:30px'><b>$staff</b></td>";
			
			
			$bg_color="#999999";
			if($open>0){$bg_color="#666666";}
			$code_tabs[1]=$bg_color;
			echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>OPEN</b><br><br>";
			echo "<font style='font-size:30px'><b>$open</b></td>";

			
			$bg_color="#999999";	
			if($unassigned>0){$bg_color="#FFCC00";}
			$code_tabs[2]=$bg_color;
			echo "<td width=34% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>UN-ASSIGNED</b><br><br>";
			echo "<font style='font-size:30px'><b>$unassigned</b></td>";

			echo "</tr>";
			echo "<tr>";
			for ($i=0;$i<=2;$i++){
				$bgcolor=$code_tabs[$i];
				echo "<td style='text-align: center; background-color: $bgcolor;' height=8px></td>";
			}
			echo "</tr>";
			echo "<tr>";
			
			
			$bg_color="#999999";
			if($emergency>0){$bg_color="#CC0000";}
			$code_tabs[0]=$bg_color;
			echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>EMERGENCY</b><br><br>";
			echo "<font style='font-size:30px'><b>$emergency</b></td>";
			

			$bg_color="#999999";
			if($low>0){$bg_color="#FFFF66";}
			$code_tabs[1]=$bg_color;
			echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>LOW</b><br><br>";
			echo "<font style='font-size:30px'><b>$low</b></td>";
				
			$bg_color="#999999";
			if($normal>0){$bg_color="#82A0DF";}
			$code_tabs[2]=$bg_color;
			echo "<td width=34% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>NORMAL</b><br><br>";
			echo "<font style='font-size:30px'><b>$normal</b></td>";
			
			echo "</tr>";
			echo "<tr>";
			for ($i=0;$i<=2;$i++){
				$bgcolor=$code_tabs[$i];
				echo "<td style='text-align: center; background-color: $bgcolor;' height=8px></td>";
			}
			echo "</tr>";
			echo "<tr>";
			
			$bg_color="#999999";
			if($high>0){$bg_color="#FF6600";}
			$code_tabs[0]=$bg_color;
			echo "<td width=33% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>HIGH</b><br><br>";
			echo "<font style='font-size:30px'><b>$high</b></td>";
				
			$bg_color="#999999";
			if($exception>0){$bg_color="#00FFFF";}
			$code_tabs[1]=$bg_color;
			echo "<td width=34% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:#666666' onclick=\"window.location='eztickets/scp/tickets.php?a=search&query=&dept=0&status=open&hide_merged_tkts=1&helptopic=&staffId=&ticketType=&startDate=&endDate=&startDueDate=&endDueDate=&stype=LIKE&sort=date&order=DESC&limit=100&advance_search=Search'\">";
			echo "<b>EXCEPTION</b><br><br>";
			echo "<font style='font-size:30px'><b>$exception</b></td>";
			
			
			$bg_color="#999999";
			
			$sql="select distinct a.ticket_id from escalations_log a where a.ticket_id in (select ticket_id from isost_ticket where status='open' and track_id!=999999)";
			$result = mysql_query($sql);
			$esc_count = mysql_num_rows($result);
			
			if($esc_count>0){$bg_color="#CC0000";}
			$code_tabs[2]=$bg_color;
			echo "<td width=34% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:9px;color:$bg_color' onclick=\"window.location='reports/escalations.php'\">";
			echo "<b>ESCALATIONS</b><br><br>";
			echo "<font style='font-size:30px'><b>$esc_count</b></td>";
			

			echo "</tr>";
			echo "<tr>";
			for ($i=0;$i<=2;$i++){
				$bgcolor=$code_tabs[$i];
				echo "<td style='text-align: center; background-color: $bgcolor;' height=8px></td>";
			}
			echo "</tr>";
			
			
		}


		echo "</table>";
?>
</td>



<td width=50%>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('datetime', 'Date');
		data.addColumn('number', 'Tickets');
		data.addColumn('number', 'Escalation 1');
		data.addColumn('number', 'Escalation 2');
		data.addColumn('number', 'Escalation 3');

<?

$end_date	=time();
$start_date	=$end_date-(86400*10); // For  last days
$graph_data	=array();
$i=0;
while ($start_date<=$end_date){
	$interim_date=$start_date+86400;
	if ($interim_date<=$end_date){
		$sql="select count(*) from isost_ticket where UNIX_TIMESTAMP(created)>=$start_date and UNIX_TIMESTAMP(created)<=$interim_date and track_id!=999999";
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);
		$tkt_count=$row[0];
		
		$sql="select distinct ticket_id from escalations_log where timestamp>=$start_date and timestamp<=$interim_date and level=1";
		$result = mysql_query($sql);
		$esc_1_count = mysql_num_rows($result);
		
		$sql="select distinct ticket_id from escalations_log where timestamp>=$start_date and timestamp<=$interim_date and level=2";
		$result = mysql_query($sql);
		$esc_2_count = mysql_num_rows($result);
		
		$sql="select distinct ticket_id from escalations_log where timestamp>=$start_date and timestamp<=$interim_date and level=3";
		$result = mysql_query($sql);
		$esc_3_count = mysql_num_rows($result);

		$print_date=$timestamp=date('d M y',$start_date);
		
		$YYYY	=date("Y",$start_date);
		$mm		=date("n",$start_date)-1;
		$dd		=date("d",$start_date);
		$time	=date("H,i,s",$start_date);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$graph_data[$i]="["."$timestamp,$tkt_count,$esc_1_count,$esc_2_count,$esc_3_count"."]";
		$i++;
		//echo "$print_date $tkt_count $esc_count <br>";
	}
	$start_date=$interim_date;
}

$graph_data=implode(",",$graph_data);

?>
		data.addRows([
		  <?
			echo $graph_data;
		  ?>
        ]);
      
        var options = {
          title: 'Tickets / Escalations - Last 10 days',
		  backgroundColor: 'E5E5E5',
		  legend: 'center',
          vAxis: {title: ""},
		  chartArea: {left:"5%", width:"75%",height:"80%"},
		  fontSize:'10', 
		  fontName:'Arial',
		  colors:['blue','#FFD800','#FF6A00','#FF0000'],
		  hAxis: {title: ""}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('tickets'));
        chart.draw(data, options);
      }
    </script>
    <div id="tickets" style="height: 250px;"></div>
</td>
</tr>
</table>