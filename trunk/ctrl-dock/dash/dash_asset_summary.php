<?
include_once("include/config.php");
include_once("include/css/default.css");
include_once("include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

$oa_compliance=1;
$url=$base_url."/api/oa_sw_register.php?key=$API_KEY";
$inactive_host_list=array();
$inactive_host_count=0;
if ($query = load_xml($url)){	
	for($i=0;$i<count($query);$i++){
		$title=$query->software[$i]->title;
		if(strlen($title)>0){
			$license_purchased	=$query->software[$i]->license_purchased;
			$software_used		=$query->software[$i]->software_used;
			$type				=$query->software[$i]->type;
			$active_count		=$query->software[$i]->active_hosts_count;
			$inactive_count		=$query->software[$i]->inactive_hosts_count;
			$sw_a_host			=$query->software[$i]->active_hosts;
			$sw_ia_host			=$query->software[$i]->inactive_hosts;
			
			$slno				=$i+1;

		
			$count=$active_count+$inactive_count;
			$status_color="black";
			if ($count>$license_purchased){$count_print="(".$count.")";$status_color="red";} else{$count_print=$count;}
		
			if($license_purchased<0){$status_color="black";}		
		
			$status="Compliant";
			$status_color="green";
			if ($count>$license_purchased){$oa_compliance=0;}
		}
	}
}
$status="Compliant";
$status_color="#339933";
if ($oa_compliance==0){$status="Not Compliant";$status_color="#CC0000";}



// To display asset summary
?>
<table border=0 width=97% cellspacing=1 cellpadding=2 >
<tr>
	<td class='reportdata' width=100%><b>ASSETS</td>
</tr>
</table>

<table class="reporttable" width=100% cellspacing=0 cellpadding=2>
<tr>
	<td class="reportheader" width=140 style='background-color:#999999'>Asset Category</td>
	<td class="reportheader" style='background-color:#999999'>Active</td>
	<td class="reportheader" style='background-color:#999999'>In-Active</td>	
	<td class="reportheader" style='background-color:#999999'>Lost</td>
	<td class="reportheader" style='background-color:#999999'>Damaged</td>
	<td class="reportheader" style='background-color:#999999'>Obsolete</td>
	<td class="reportheader" style='background-color:#999999'>Others</td>
	<td class="reportheader" style='background-color:#999999'>Total</td>
	<td rowspan=5 class='reportdata' style='color:white;text-align:center;' width=120><a href='ezasset/sw_compliance.php' style="text-decoration:none;color:#333333;"><b>SOFTWARE LICENSING<br><br><?=$status?></b></a></td>
	<td rowspan=5 class='reportdata' style='color:white;text-align:center;background-color:<?=$status_color;?>' width=2></td>
	</td>
</tr>
<?
$categories=array('Desktop','Laptop','Server-Tower','Server-RackMount');
for ($j=0;$j<count($categories);$j++){
	$asset=$categories[$j];	
	$url=$base_url."/api/ast_count_type.php?key=$API_KEY&asset=$asset";
	
	if ($query = load_xml($url)){		
		for($i=0;$i<count($query);$i++){
			$type_id=$query->asset[$i]->type_id;			
			$active=$query->asset[$i]->active;
			$inactive=$query->asset[$i]->inactive;
			$lost=$query->asset[$i]->lost;
			$damaged=$query->asset[$i]->damaged;
			$obsolete=$query->asset[$i]->obsolete;
			$others=$query->asset[$i]->others;
			$total=$query->asset[$i]->total;

			echo "<tr bgcolor=#F0F0F0>";
			echo "<td class='reportdata'><font size=2><b>$asset</td>";
			echo "<td class='reportdata' style='text-align: center;'>$active</td>";
			echo "<td class='reportdata' style='text-align: center;'>$inactive</td>";
			echo "<td class='reportdata' style='text-align: center;'>$lost</td>";
			echo "<td class='reportdata' style='text-align: center;'>$damaged</td>";
			echo "<td class='reportdata' style='text-align: center;'>$obsolete</td>";
			echo "<td class='reportdata' style='text-align: center;'>$others</td>";
			echo "<td class='reportdata' style='text-align: center;background-color:#CCCCFF'><b><a href=ezasset/listasset.php?assetid=%&assetcategoryid=$type_id&statusid=%&employee=%&hostname=% style='text-decoration:none;color:#333333;'>$total</a></b></td>";		
			echo "</tr>";
		}
	}
}
echo "</table>";
// End of asset summary
?>