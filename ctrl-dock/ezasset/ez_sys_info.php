<center>
<?
$system_name=$_REQUEST["system_name"];
$system_name_lc=strtolower($system_name);
$system_name_uc=strtoupper($system_name);

include_once("list_include.php");

$db = mysql_connect($mysql_server,$mysql_user,$mysql_password) or die('Could not connect: ' . mysql_error());
mysql_select_db($mysql_database,$db);

$SQL = "SELECT system_uuid from system where system_name='$system_name_lc' or system_name='$system_name_uc'";
$result = mysql_query($SQL, $db);
$record_count  = mysql_num_rows($result);

if ($record_count>0){
	$row = mysql_fetch_row($result);
	$system_uuid=$row[0];
	echo "<b>Please wait while this page loads</b>";
?>
	<meta http-equiv="refresh" content="0;url=system.php?pc=<?echo $system_uuid;?>&view=summary">
<?
	
}else{
	echo "There is no additional information available for this asset";
}
?>
