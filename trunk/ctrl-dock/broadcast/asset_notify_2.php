<?include("config.php"); ?>
<?include("header.php");?>

<?	
$sql="select email from asset_template";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$template=$row[0];


$sql="select distinct a.employee,b.official_email,b.first_name,b.last_name from asset a, user_master b ";
$sql.=" where a.employee=b.username and b.account_status='Active' and a.statusid='1' and b.username!='administrator' order by b.username";

$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)){
	$full_name	=$row[2]." ".$row[3];
	$employee	=$row[0];
	$email		=$row[1];
	$message	=str_replace('%%user',$row[2],$template);
	
	$sub_sql="select a.assetid,a.assetidentifier,a.model,a.serialno,b.assetcategory from asset a, assetcategory b where a.assetcategoryid=b.assetcategoryid and a.employee='$employee'";
	$sub_result = mysql_query($sub_sql);
	$asset="<table border=1 cellspacing=0 cellpadding=3>";
	$asset.="<tr>";
	$asset.="<td><b>Asset ID</td>";
	$asset.="<td><b>Asset Tag</td>";
	$asset.="<td><b>Category</td>";
	$asset.="<td><b>Model</td>";
	$asset.="<td><b>Serial No </td>";
	$asset.="</tr>";
	while ($sub_row = mysql_fetch_row($sub_result)){
		$assetid	=$ASSET_PREFIX."-".str_pad($sub_row[0], 5, "0", STR_PAD_LEFT);
		$assettag	=$sub_row[1];
		$category	=$sub_row[4];
		$model		=$sub_row[2];
		$serialno	=$sub_row[3];
		
		$asset.="<tr>";
		$asset.="<td>$assetid</td>";
		$asset.="<td>$assettag</td>";
		$asset.="<td>$category</td>";
		$asset.="<td>$model</td>";
		$asset.="<td>$serialno</td>";
		$asset.="</tr>";
	}
	$asset.="</table>";
	$message	=str_replace('%%asset',$asset,$message);
	$subject	="Asset Verification Request";
	ezmail("$email","$email",$subject,$message,"",true);
}
echo "<center><br><font face=Arial size=2 color=black>The notification has been sent successfully.</font>";
?>