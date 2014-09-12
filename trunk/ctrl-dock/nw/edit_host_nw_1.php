<?php 
include("config.php"); 
if (!check_feature(31)){feature_error();exit;}


$host_id	=$_REQUEST["host_id"];
$hostname	=$_REQUEST["hostname"];

$sql = "select count,timeout,enabled,alarm_threshold,flap_timeout,flap_threshold from hosts_nw where host_id='$host_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$count	=$row[0];
$timeout=$row[1];
$enabled=$row[2];
$alarm_threshold=$row[3];
$flap_timeout=$row[4];
$flap_threshold=$row[5];

$status_text="Active";
if($enabled==0){$status_text="Disabled";}

$SELECTED="PING CONFIGURATION : ".$hostname;
include("header.php");
?>

<form method=POST action=edit_host_nw_2.php?host_id=<?echo $host_id;?>>

<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>No. of Pings</b></td>
	<td align=right><input name="count" size="10" class='forminputtext' value='<?echo $count;?>'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Ping Timeout (in secs)</b></td>
	<td align=right><input name="timeout" size="10" class='forminputtext' value='<?echo $timeout;?>'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Alarm Threshold</b></td>
	<td align=right><input name="alarm_threshold" size="10" class='forminputtext' value='<?echo $alarm_threshold;?>'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Flapping Timeout (in ms)</b></td>
	<td align=right><input name="flap_timeout" size="10" class='forminputtext' value='<?echo $flap_timeout;?>'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Flapping Threshold</b></td>
	<td align=right><input name="flap_threshold" size="10" class='forminputtext' value='<?echo $flap_threshold;?>'></td>
</tr>
<tr>
<td class='tdformlabel'><b>Status</font></b></td>
        <td align=right>
                <select size=1 name=enabled class='formselect'>
					<option value='<?echo $enabled;?>'><?echo $status_text;?></option>
                    <option value='1'>Active</option>
					<option value='0'>Disabled</option>
                </select>
        </td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>