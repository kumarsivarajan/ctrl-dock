<?include("config.php"); ?>
<?
$SELECTED="NETWORK HOSTS";
include("header.php");
?>

<table class="reporttable" width=100%>
<tr>
	<td colspan=10 align=right>
		<a style="text-decoration: none" href="add_host.php">
		<font color="#99CC33" face="Arial" size="2"><b>Add Host</font></a>
	</td>
</tr>

<tr>
	<td class="reportheader">Description</td>
	<td class="reportheader">Hostname / IP Address</td>
	<td class="reportheader">Platform</td>
	<td class="reportheader">Status</td>
	<td class="reportheader" width=60>Ping</td>
	<td class="reportheader" width=60>Services</td>
	<td class="reportheader" width=60>SNMP</td>
	<td class="reportheader" width=60>Edit</td>
	<td class="reportheader" width=60>Email</td>
	<td class="reportheader" width=60>Delete</td>
</tr>
<?php
$sql = "select host_id,hostname,platform,status,description from hosts_master order by description,hostname";
$result = mysql_query($sql);
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	$status="Active";
	if($row[3]==0){$status="Disabled";}
	$description=$row[4];
	if(strlen($description)==0){
		$description=$row[1];
	}
	?>
	<tr bgcolor=<?echo $row_color; ?>>
		
		<td class='reportdata'><? echo $description; ?></td>
		<td class='reportdata'><? echo $row[1]; ?></td>
		<td class='reportdata'><? echo $row[2]; ?></td>
		<td class='reportdata' style='text-align: center;'><? echo $status; ?></td>
		<td class='reportdata' style='text-align: center;'><a href="edit_host_nw_1.php?host_id=<? echo $row[0]; ?>&hostname=<?echo $row[1];?>"><img border=0 src="images/network.gif"></a></td>
		<td class='reportdata' style='text-align: center;'><a href="host_svc.php?host_id=<? echo $row[0]; ?>&hostname=<?echo $row[1];?>"><img border=0 src="images/services.gif"></a></td>
		<td class='reportdata' style='text-align: center;'><a href="edit_host_nw_snmp_1.php?host_id=<? echo $row[0]; ?>&hostname=<?echo $row[1];?>"><img border=0 src="images/snmp.gif"></a></td>
		<td class='reportdata' style='text-align: center;'><a href="edit_host_1.php?host_id=<? echo $row[0]; ?>"><img border=0 src="images/edit.gif"></a></td>
		<td class='reportdata' style='text-align: center;'><a href="mail_uptime_notification.php?host_id=<? echo $row[0]; ?>&hostname=<?echo $row[1];?>"><img border=0 src="images/email.gif"></a></td>
		<td class='reportdata' width=40 style='text-align: center;'><a href='host_delete_cf.php?host_id=<?echo $row[0];?>&hostname=<?echo $row[1];?>'><img src=images/delete.gif border=0></img></a></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>
</body>
</html>
