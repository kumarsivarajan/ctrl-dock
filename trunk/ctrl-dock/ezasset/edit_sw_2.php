<?include("config.php"); ?>

<?
$asset_db            =$DATABASE_NAME."_oa";


$id=$_REQUEST["id"];

$procurement_source=$_REQUEST["procurement_source"];
$procurement_date=$_REQUEST["procurement_date"];
$procurement_vendor=$_REQUEST["procurement_vendor"];
$license_type=$_REQUEST["license_type"];
$quantity=$_REQUEST["quantity"];if($quantity<0){$error_code=2;}
$comments=$_REQUEST["comments"];

if ($error_code==0){
	mysql_select_db($asset_db, $link);
	$sql ="update sw_licenses set procurement_source='$procurement_source',procurement_date='$procurement_date',";
	$sql.="procurement_vendor='$procurement_vendor',license_type='$license_type',quantity='$quantity',comments='$comments' where package_id='$id'";
	$result = mysql_query($sql);
	echo "<h2>The License has been edited. Please wait</h2>";
}else{
	echo "<h2>Few mandatory fields were not filled.<br><br></h2>";
}

?>
  <meta http-equiv="Refresh" content="1; URL=add_sw_1.php">