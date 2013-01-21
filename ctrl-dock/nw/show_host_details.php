<?php 
include("config.php"); 

$hostname	=$_REQUEST["hostname"];
$records	=$_REQUEST["records"];
if(strlen($records)<=0){
	$records=60;
}
$query_host_master = sprintf("SELECT host_id 
 		FROM hosts_master 
		WHERE hostname='%s'",$hostname);
$result = mysql_query($query_host_master);
$row	= mysql_fetch_row($result);
$host_id=$row[0];
?>
<title>Load / Performance Statistics : <?=$hostname;?></title>

<table class="reporttable" width=990 border=0>
<tr>
<td width=60% class='reportdata' style='text-align:left;'>
	<b>Host / FQDN : <?=$hostname;?></b>
</td>
<td>

<td width=30% class='reportdata' style='text-align:center;'>
	<form method=POST action=show_host_details.php?hostname=<?=$hostname;?> id=refresh>
			<h4>Display Last <input name="records" size="3" value=<?=$records;?> class='forminputtext' onBlur=document.forms["refresh"].submit(); > Records
	</form>
</td>
<td width=10% class='reportdata' style='text-align:right;'>
	<a href=javascript:history.back();>BACK</a>
</td>
</tr>

</table>

<?
$sql = "select timestamp,min,avg,max from hosts_nw_log where host_id='$host_id' order by record_id desc LIMIT $records";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

if ($record_count>0){
?>
<table class="reporttable" width=990 cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>NETWORK RESPONSE</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:center; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('ping_history.php?hostname=<?=$hostname; ?>&records=<?=$records;?>','Ping Statistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>
<?


	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$graph_data[$i]="["."$timestamp,$row[1],$row[2],$row[3]"."]";
		$i++;
	}

	$graph_data=implode(",",$graph_data);

	$x_axis_label="Time";
	$y_axis_label="Average Ping m/s";
	$graph_title="Network Response";
	$graph_name="ping_history";
	$graph_width="99%";
	$graph_height="300px";
	include("host_graph.php");
?>
</td></tr>
</table>
<?}?>






<?
$sql = "select timestamp,cpu_user,cpu_system,mem_utilization from hosts_nw_snmp_log where host_id='$host_id' order by record_id desc LIMIT $records";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if ($record_count>0){
?>
<table class="reporttable" width=990 cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>RESOURCE UTILIZATION</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20><a href='javascript:void(0);'  onclick="javascript:window.open('snmp_history.php?hostname=<?=$hostname;?>&records=<?=$records;?>','SNMPStatistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=600,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>

<?
	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$cpu=$row[1]+$row[2];
		$mem=$row[3];
		
		$graph_data[$i]="["."$timestamp,$cpu,$mem"."]";
		$i++;
	}
	$graph_data=implode(",",$graph_data);

	$x_axis_label="Time";
	$y_axis_label="% Utilization";
	$graph_title="Resource Utilization";
	$graph_name="resource_utilization";
	$graph_width="99%";
	$graph_height="300px";
	include("snmp_graph.php");
?>
</td></tr>
</table>
<?}?>


<?

$sql 	= "SELECT port,description FROM hosts_service WHERE enabled=1 and host_id='$host_id' order by description";
$result = mysql_query($sql);

$record_count=mysql_num_rows($result);
if ($record_count>0){
?>
<table class="reporttable" width=990 cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>SERVICE AVAILABILITY</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:left; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('svc_history.php?hostname=<?=$hostname;?>&records=<?=$records;?>','Service Status History','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>

<tr><td colspan=2 class=reportdata style="text-align:center;" >
<?
	$graph_data	=array();
	$i=0;

	while ($row = mysql_fetch_row($result)){
		$port           =$row[0];
		$description    =$row[1];

		$sub_sql = "SELECT a.svc_status FROM hosts_service_log a WHERE a.host_id='$host_id' AND a.port='$port' ORDER BY record_id DESC LIMIT $records";
		$sub_result = mysql_query($sub_sql);
		$record_count=mysql_num_rows($sub_result);
		$up_count=0;
		while ($sub_row = mysql_fetch_row($sub_result)){
			if($sub_row[0]==1){$up_count++;}
		}
		
		$svc_availability=($up_count/$record_count)*100;
		$svc_availability=round($svc_availability,1);
		
		$graph_data[$i]="['"."$description"."',".$svc_availability."]";
		$i++;
	}

	$graph_data=implode(",",$graph_data);

	$graph_title="Service Availability";
	$graph_name="service_availability";
	include("all_service_graph.php");
?>
</td></tr>
</table>
<?}?>




