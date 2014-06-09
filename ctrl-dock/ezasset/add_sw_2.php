<?include("config.php"); ?>

<?
$asset_db            =$DATABASE_NAME."_oa";


$error_code=0;
$package_name=$_REQUEST["package_name"];
if($package_name=="other"){$package_name=$_REQUEST["other_package"];}

if(strlen($package_name)<=0){$error_code=1;}

$procurement_source=$_REQUEST["procurement_source"];
$procurement_date=$_REQUEST["procurement_date"];
$procurement_vendor=$_REQUEST["procurement_vendor"];
$license_type=$_REQUEST["license_type"];
$quantity=$_REQUEST["quantity"];if($quantity<0){$error_code=2;}
$comments=$_REQUEST["comments"];

if ($error_code==0){
	mysql_select_db($asset_db, $link);
	mysql_query("SET NAMES `utf8`");
	$sql ="insert into sw_licenses (package_name,procurement_source,procurement_date,procurement_vendor,license_type,quantity,comments)";
	$sql.=" values ('$package_name','$procurement_source','$procurement_date','$procurement_vendor','$license_type','$quantity','$comments')";
	$result = mysql_query($sql);
	
	echo "<h2>The License has been added. Please wait</h2>";
}else{
	echo "<h2>Few mandatory fields were not filled.<br><br></h2>";
}

?>
  <meta http-equiv="Refresh" content="1; URL=add_sw_1.php">