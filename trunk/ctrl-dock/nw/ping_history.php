<?php 
include("config.php"); 

$hostname	=$_REQUEST["hostname"];
$timedetail	=$_REQUEST["timedetail"];
$fromdate	=$_REQUEST["fromdate"];
$todate		=$_REQUEST["todate"];

$sql	="select host_id from hosts_master where hostname='$hostname'";
$result = mysql_query($sql);
$row	= mysql_fetch_row($result);
$host_id=$row[0];
?>
<title>Ping Statistics : <?=$hostname;?></title>
<table class="reporttable" width=500 border=0>
<tr><td class='reportdata' colspan=5><b>Ping Statistics : <?=$hostname;?></b></td></tr>
</table>
<table class="reporttable" width=500>
<td class='reportdata' style='text-align:center;' colspan=6>
</td>
</tr>
<tr><td colspan=6>
<?
$sql="select timestamp,nw_status,min,avg,max from hosts_nw_log where host_id='$host_id'";
if(strlen($timedetail)>0){
	$sql.= " and timestamp >= '$timedetail' order by record_id desc";
}else{
	$sql.= " and timestamp BETWEEN '$fromdate' and '$todate' order by record_id desc";
}

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=$record_count-1;
$graph_data	=array();
$summary	=array();

while ($row = mysql_fetch_row($result)){

	$summary[$i][0]=$row[0];
	$summary[$i][1]=$row[1];
	$summary[$i][2]=$row[2];
	$summary[$i][3]=$row[3];
	$summary[$i][4]=$row[4];
	
	$graph_data_old[$i]=$row[3];
	$graph_start_date=$row[0]*1000;
	$i--;
}
$graph_data = array_reverse($graph_data_old);
$graph_data_export=implode(",",$graph_data);

$x_axis_label="Last $records Pings";
$y_axis_label="Average Ping m/s";
$y_min=0;
$y_max=0;
$pt_label="Average Ping";
$graph_name="ping_history";
$graph_width="100%";
$graph_height="300px";
//include("host_graph.php");
?>
</td></tr>

<tr>
	<td class="reportheader" width=125 colspan=2>Date & Time</td>	
	<td class="reportheader" width=85>Status</td>
	<td class="reportheader" width=80>Min</td>
	<td class="reportheader" width=80>Avg</td>
	<td class="reportheader" width=80>Max</td>
</tr>
<?
$sl_no=1;

for($i=0;$i<=count($graph_data)-1;$i++){

	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	
	$date	=$summary[$i][0];
	$status	=$summary[$i][1];
	$min	=$summary[$i][2];
	$avg	=$summary[$i][3];
	$max	=$summary[$i][4];

	if ($status==1){$bgcolor="#00CC00";$text="UP";}
	if ($status==0){$bgcolor="#FF0000";$text="DOWN";}
	
	
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata' style='text-align:center;'><?=$sl_no;?></td>
		<td class='reportdata' style='text-align:center;'><?=date('d M Y H:i:s',$date)?></td>
		<td class='reportdata' style='text-align:center;background-color: <?echo $bgcolor;?>'><?=$text;?></td>
		<td class='reportdata' style='text-align:center;'><?=$min;?> ms</td>
		<td class='reportdata' style='text-align:center;'><?=$avg;?> ms</td>
		<td class='reportdata' style='text-align:center;'><?=$max;?> ms</td>
	</tr>
	
<?
	$sl_no++;
}
?>
</table>
