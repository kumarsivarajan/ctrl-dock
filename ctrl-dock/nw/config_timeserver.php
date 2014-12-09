<?php 
include("config.php"); 
$SELECTED="Configure Time Servers";
include("header.php");

if (!check_feature(30)){feature_error();exit;}



$timeserver=mysql_real_escape_string($_REQUEST["timeserver"]);
$threshold=mysql_real_escape_string($_REQUEST["threshold"]);
$action=mysql_real_escape_string($_REQUEST["action"]);


$sql="select timeservers,diffthreshold from hosts_timesync_config";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

?>


<form method=POST action=config_timeserver.php?action=save>

<table border=0 cellpadding=1 cellspacing=1 width=100% bgcolor=#F7F7F7>

<tr>
	<td class='tdformlabel'><b>Time Servers (Comma Separated Values)</font></b></td>
	<td align=right><input value="<?=$row[0];?>" name="timeserver" size="40" class='forminputtext'></td>
</tr>

<tr>
	<td class='tdformlabel'><b>Difference Threshold </font></b></td>
	<td align=right><input value="<?=$row[1];?>" name="threshold" size="40" class='forminputtext'></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</form>
</table>
<?
 if ($action=="save"){
  	$sql = "delete from hosts_timesync_config";
	mysql_query($sql);
 	$sql = "INSERT INTO hosts_timesync_config values ('$timeserver','$threshold')";
	mysql_query($sql);
?>
	<center><b><font color="#003366" face="Arial" size=2>The time server configuration was saved successfully.</font></b></center>
	<meta http-equiv="Refresh" content="2; URL=configure.php">
<?
}
?>