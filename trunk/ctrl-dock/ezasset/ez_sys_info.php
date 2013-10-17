<?include("config.php"); ?>
<center>
<?

$asset_db            =$DATABASE_NAME."_oa";

$system_name=$_REQUEST["system_name"];
$system_name_lc=strtolower($system_name);
$system_name_uc=strtoupper($system_name);

mysql_select_db($asset_db, $link);
$sql = "SELECT system_id from system where hostname='$system_name_lc' or hostname='$system_name_uc'";
$result = mysql_query($sql);
$record_count  = mysql_num_rows($result);

if ($record_count>0){
	$row = mysql_fetch_row($result);
	$system_id=$row[0];
	echo "<b>Please wait while this page loads</b>";
?>
	<meta http-equiv="refresh" content="0;url=../OA2/index.php/main/system_display/<?=$system_id;?>">
<?
	
}else{
	echo "There is no additional information available for this asset";
}
?>
