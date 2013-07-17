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
<title>SNMP Statistics: <?=$hostname;?></title>
<table class="reporttable" width=710 border=0>
<tr><td class='reportdata' colspan=5><b>SNMP Statistics : <?echo $hostname;?></b></td></tr>
</table>
<table class="reporttable" width=710 cellpadding=2>
</tr>
<tr>
	<td class="reportheader" width=200 colspan=2>Date & Time</td>	
	<td class="reportheader" width=100>CPU User</td>
	<td class="reportheader" width=100>CPU System</td>
	<td class="reportheader" width=100>CPU Idle</td>
	<td class="reportheader" width=110>Memory Utilization</td>
	<td class="reportheader" width=100>Disk Utilization</td>
</tr>
<?
$sql = "select timestamp,nw_snmp_cpu_status,nw_snmp_mem_status,cpu_user,cpu_system,cpu_idle,mem_utilization,nw_snmp_dsk_status,disk_utilization from hosts_nw_snmp_log where host_id='$host_id'";
if(strlen($timedetail)>0){
	$sql.= "and timestamp >= '$timedetail' order by record_id desc";
}else{
	$sql.= "and timestamp BETWEEN '$fromdate' and '$todate' order by record_id desc";
}

$result = mysql_query($sql);
$i=0;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
		
	if ($row[1] == 1){
		$cpu_bgcolor = "#00CC00";
	}else if ($row[1] == -1){
		$cpu_bgcolor = "#A9A9A9";
	}else if ($row[1] == 0){
		$cpu_bgcolor = "#FF0000";
	}
	
	if ($row[2] == 1){
		$mem_bgcolor = "#00CC00";
	}else if ($row[2] == -1){
		$mem_bgcolor = "#A9A9A9";
	}else if ($row[2] == 0){
		$mem_bgcolor = "#FF0000";
	}
	
	if ($row[7] == 1){
		$dsk_bgcolor = "#00CC00";
	}else if ($row[7] == -1){
		$dsk_bgcolor = "#A9A9A9";
	}else if ($row[7] == 0){
		$dsk_bgcolor = "#FF0000";
	}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata' style='text-align:center;'><?=$i+1;?></td>
		<td class='reportdata' style='text-align:center;'><? echo date('d M Y H:i:s',$row[0]); ?></td>
		<td class='reportdata' style='text-align:center;background-color: <?echo $cpu_bgcolor;?>'><? if("-1"==$row[3]){echo "NA";}else{echo $row[3] . "%";} ?></td>
		<td class='reportdata' style='text-align:center;background-color: <?echo $cpu_bgcolor;?>'><? if("-1"==$row[4]){echo "NA";}else{echo $row[4] . "%";} ?></td>
		<td class='reportdata' style='text-align:center;background-color: <?echo $cpu_bgcolor;?>'><? if("-1"==$row[5]){echo "NA";}else{echo $row[5] . "%";} ?></td>
		<td class='reportdata' style='text-align:center;background-color: <?echo $mem_bgcolor;?>'><? if("-1"==$row[6]){echo "NA";}else{echo $row[6]  . "%";} ?></td>
		<td class='reportdata' style='text-align:left  ;background-color: <?echo $dsk_bgcolor;?>'><? if("0"==$row[8]){echo "NA";}else{echo $row[8];} ?></td>
	</tr>
<?
	$i++;
	}
?>
</table>
