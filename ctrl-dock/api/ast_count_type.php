<?php
header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to list the count of assets based on the type
// ast_count_typephp?key=abcd&asset=desktop
// possible assets : desktop, laptop, server-tower, server-rack

function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

function showxml($asset_category,$active,$inactive,$lost,$damaged,$obsolete,$others){
	echo "<node>";
		echo "<asset>";
				echo "<type_id>".$asset_category."</type_id>";
				echo "<active>".$active."</active>";
				echo "<inactive>".$inactive."</inactive>";
				echo "<lost>".$lost."</lost>";
				echo "<damaged>".$damaged."</damaged>";
				echo "<obsolete>".$obsolete."</obsolete>";
				echo "<others>".$others."</others>";
				$total=$active+$inactive+$lost+$damaged+$obsolete+$others;
				echo "<total>".$total."</total>";
		echo "</asset>";
	echo "</node>";
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$asset			= strip_tags($_REQUEST['asset']);


if ($asset=="Desktop"){$asset_category="1";}
if ($asset=="Laptop"){ $asset_category="2";}
if ($asset=="Server-Tower"){$asset_category="19";}
if ($asset=="Server-RackMount"){$asset_category="20";}

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='1'");
		$row = mysql_fetch_array($result);		
		$active=$row['count'];
		
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='2'");
		$row = mysql_fetch_array($result);		
		$inactive=$row['count'];
		
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='3'");
		$row = mysql_fetch_array($result);		
		$lost=$row['count'];
		
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='4'");
		$row = mysql_fetch_array($result);		
		$damaged=$row['count'];
		
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='6'");
		$row = mysql_fetch_array($result);		
		$obsolete=$row['count'];
		
		$result = mysql_query("SELECT count(*) as count FROM asset WHERE assetcategoryid='$asset_category' AND statusid='5'");
		$row = mysql_fetch_array($result);		
		$others=$row['count'];
	
		showxml($asset_category,$active,$inactive,$lost,$damaged,$obsolete,$others);	
		
}
?>
