<center>
<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5>
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
	<font face=Arial size=2 color=#CC0000><b>BLACK-LISTED ASSETS<br><font face=Arial size=1 color=#000000>These assets were reporting to the system and were not identifiable physically and were probably black-listed.</b></font>
	</td>
	<td width=10% align=right>
	<a href=../settings/settings.php><font face=Arial size=1>BACK </font></a>
	</td>
	</tr>
</table>
<br>
<table border=0 width=100% cellpadding="10" cellspacing="0" bgcolor=#EEEEEE>
<?
include_once("list_include.php");

$action=$_REQUEST['action'];
$uuid=$_REQUEST['uuid'];


$db = mysql_connect($mysql_server,$mysql_user,$mysql_password) or die('Could not connect: ' . mysql_error());
mysql_select_db($mysql_database,$db);


if($action=="wl"){
	$SQL = "delete from black_list where system_uuid='$uuid'";
	$result = mysql_query($SQL, $db);
}

$SQL = "SELECT system_uuid,system_name from black_list order by system_name";
$result = mysql_query($SQL, $db);
$record_count  = mysql_num_rows($result);

if ($record_count>0){
	while ($row = mysql_fetch_row($result)){
		echo "<tr><td><font face=Arial size=2><b>$row[1]</b></td><td><font face=Arial size=2><a href=asset_blacklist.php?uuid=$row[0]&action=wl>[white-list]</a></td></tr>";
	}	
}else{
	echo "<tr><td><font face=Arial size=2>There are no black-listed assets</td></tr>";
}
?>
</table>
