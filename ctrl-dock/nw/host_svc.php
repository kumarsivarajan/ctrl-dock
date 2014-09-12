<?php 
include("config.php");
if (!check_feature(31)){feature_error();exit;}
 

$host_id	=$_REQUEST["host_id"];
$hostname	=$_REQUEST["hostname"];
$status_text="Active";
if($enabled==0){$status_text="Disabled";}

$SELECTED="Service Configuration : ".$hostname;
include("header.php");
?>

<form method=POST action=add_host_svc.php?host_id=<?echo $host_id;?>&hostname=<?echo $hostname;?>>

<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>Name of the Service</font></b></td>
	<td align=right><input name="description" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Monitor Port</font></b></td>
	<td align=right><input name="port" size="10" class='forminputtext'></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td class='tdformlabel'><b>Monitor URL</font></b></td>
	<td align=right><input name="url" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Check Pattern</font></b></td>
	<td align=right><input name="pattern" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>URL Timeout (in secs)</font></b></td>
	<td align=right><input name="url_timeout" size="10" class='forminputtext'></td>
</tr>

<tr><td>&nbsp;</td></tr>
<tr>
	<td class='tdformlabel'><b>Alarm Threshold</font></b></td>
	<td align=right><input name="alarm_threshold" size="10" class='forminputtext'></td>
</tr>
<tr>
<td class='tdformlabel'><b>Status</font></b></td>
        <td align=right>
                <select size=1 name=enabled class='formselect'>					
                    <option value='1'>Active</option>
					<option value='0'>Disabled</option>
                </select>
        </td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Add Service" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
<br>
<table class="reporttable" width=100%>
<tr>
	<td class="reportheader">Description</td>
	<td class="reportheader">Port</td>
	<td class="reportheader" width=50>Status</td>
	<td class="reportheader" width=100>Alarm Threshold</td>
	<td class="reportheader" width=200>URL</td>
	<td class="reportheader" width=200>Pattern</td>
	<td class="reportheader" width=100>URL Timeout</td>
	<td class="reportheader" width=60>Delete</td>
</tr>
<?
$i=0;
$sql = "select description,port,enabled,alarm_threshold,url,pattern,timeout from hosts_service where host_id='$host_id' order by description";
$result = mysql_query($sql);
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
	$status="Active";
	if($row[2]==0){$status="Disabled";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class='reportdata'><? echo $row[0]; ?></td>
		<?
		$port=$row[1];
		$timeout="";
		if($row[1]=="0"){$port="Site Check";$timeout=$row[6]." secs";}
		?>
		<td class='reportdata' style='text-align: center;'><? echo $port; ?></td>
		<td class='reportdata' style='text-align: center;'><? echo $status; ?></td>
		<td class='reportdata' style='text-align: center;'><? echo $row[3]; ?></td>
		<td class='reportdata'><? echo $row[4]; ?></td>
		<td class='reportdata'><? echo $row[5]; ?></td>
		<td class='reportdata'><? echo $timeout; ?></td>

		<td class=reportdata width=40 style='text-align: center;'><a href='host_svc_delete.php?host_id=<?echo $host_id;?>&port=<?echo $row[1];?>&hostname=<?echo $hostname;?>&url=<? echo $row[4];?>'><img src=images/delete.gif border=0></img></a></td>
	</tr>
<? $i++; }?>
</table>
