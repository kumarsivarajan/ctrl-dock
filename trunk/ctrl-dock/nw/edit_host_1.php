<?php 
include("config.php"); 
if (!check_feature(31)){feature_error();exit;}



$host_id=$_REQUEST["host_id"];

$sql = "select hostname,platform,status,description,alert_status from hosts_master where host_id='$host_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$hostname=$row[0];
$platform=$row[1];
$status=$row[2];
$description=$row[3];

$alert_status=$row[4];
$alert_status_text="Active";
if($alert_status==0){$alert_status_text="Disabled";}


$status_text="Active";
if($status==0){$status_text="Disabled";}

$SELECTED="EDIT HOST : ".$hostname;
include("header.php");
?>

<form method=POST action=edit_host_2.php?host_id=<?echo $host_id;?>>

<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
	<td class='tdformlabel'><b>Description</font></b></td>
	<td align=right><input name="description" size="40" class='forminputtext' value="<?echo htmlentities($description);?>"></td>
</tr>
<tr>
	<td class='tdformlabel'><b>Hostname / IP Address</font></b></td>
	<td align=right><input name="hostname" size="40" class='forminputtext' value="<?echo htmlentities($hostname);?>"></td>
</tr>
<tr>
<td class='tdformlabel'><b>Platform</font></b></td>
        <td align=right>
                <select size=1 name=platform class='formselect'>
					<option value='<?echo $platform;?>'><?echo $platform;?></option>
                    <option value='WIN'>WINDOWS</option>
					<option value='LINUX'>LINUX</option>
					<option value='UNIX'>UNIX</option>
					<option value='OTHERS'>OTHERS</option>
                </select>
        </td>
</tr>
<tr>
<td class='tdformlabel'><b>Monitoring Status</font></b></td>
        <td align=right>
                <select size=1 name=status class='formselect'>
					<option value='<?echo $status;?>'><?echo $status_text;?></option>
                    <option value='1'>Active</option>
					<option value='0'>Disabled</option>
                </select>
        </td>
</tr>
<tr>
<td class='tdformlabel'><b>Alert Status</font></b></td>
        <td align=right>
                <select size=1 name=alert_status class='formselect'>
					<option value='<?echo $alert_status;?>'><?echo $alert_status_text;?></option>
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