<?
include_once("config.php");
include_once("searchasset.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

// To display software compliance summary
?>
<link rel="stylesheet" href="../include/css/tinyboxstyle.css" />
<script type="text/javascript" src="../include/js/tinybox.js"></script>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' width=100%><b>Software Compliance as on date</td>
</tr>
</table>

<table class="reporttable" width=100% cellspacing=1 cellpadding=5>
<tr>
	<td class="reportheader">Sl.No.</td>
	<td class="reportheader">Software</td>
	<td class="reportheader">Licenses</td>
	<td class="reportheader">Active</td>
	<td class="reportheader">In-Active</td>
	<td class="reportheader">Total</td>
	<td class="reportheader">Compliance</td>	
</td>
</tr>
<?

$url=$base_url."/api/oa_sw_register.php?key=$API_KEY";

$inactive_host_list=array();
$inactive_host_count=0;
if ($query = load_xml($url)){
	$row_color="#FFFFFF";
	for($i=0;$i<count($query);$i++){
		if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
		$title		=$query->software[$i]->title;
		if(strlen($title)>0){
			$license_purchased	=$query->software[$i]->license_purchased;
			$software_used		=$query->software[$i]->software_used;
			$type				=$query->software[$i]->type;
			$active_count		=$query->software[$i]->active_hosts_count;
			$inactive_count		=$query->software[$i]->inactive_hosts_count;
			$sw_a_host			=$query->software[$i]->active_hosts;
			$sw_ia_host			=$query->software[$i]->inactive_hosts;
			
			$slno				=$i+1;
			
			echo "<tr bgcolor=$row_color>";
			echo "<td class='reportdata' style='text-align: center;' width=30>$slno</td>";
			echo "<td class='reportdata' >$title</td>";
			if($license_purchased>=0){
				echo "<td class='reportdata' style='text-align: center;' width=60>$license_purchased</td>";
			}else{
				echo "<td class='reportdata' style='text-align: center;' width=60>NA</td>";
			}
		
			$count=$active_count+$inactive_count;
			$status_color="black";
			if ($count>$license_purchased){$count_print="(".$count.")";$status_color="red";} else{$count_print=$count;}
			
			if($license_purchased<0){$status_color="black";}		
			echo "<td class='reportdata' style='color: $status_color;text-align: center;' width=60 ONCLICK=\"TINY.box.show({html:'$sw_a_host',animate:false,close:true,boxid:'error',top:5})\">$active_count</td>";
			echo "<td class='reportdata' style='color: $status_color;text-align: center;' width=60 ONCLICK=\"TINY.box.show({html:'$sw_ia_host',animate:false,close:true,boxid:'error',top:5})\">$inactive_count</td>";
			echo "<td class='reportdata' style='color: $status_color;text-align: center;' width=60>$count</td>";
			
			$status="Compliant";
			$status_color="green";
			if ($count>$license_purchased){$status="Not Compliant";$status_color="red";}
			if($license_purchased<0){$status="Compliant";$status_color="green";}
			echo "<td class='reportdata' style='color:$status_color' width=80><b>$status</b></td>";
			echo "</tr>";
		}
	}
}
echo "<tr bgcolor=#F0F0F0>";
echo "<td class='reportdata' style='color:#111111' colspan=7>Click on the Active / In-Active counts to get a list of hosts which have installations of a specific software</td>";
echo "</tr>";


$inactive_host_list=array_unique($inactive_host_list);
$inactive_count=count($inactive_host_list);

if ($inactive_count>0){
	echo "<tr bgcolor=#E0E0E0><td class='reportdata' colspan=7 width=100%>";
	echo "<b>The following hosts are reporting, but could not be mapped in the Physical Asset Database. Verify and correct the same to ensure accuracy of the compliance data.</b><br><br>";
	for($i=0;$i<count($inactive_host_list);$i++){
		$inactive_host=$inactive_host_list[$i];
		if(strlen($inactive_host)>0){
			echo "<a target=_blank href=ez_sys_info.php?system_name=$inactive_host>$inactive_host</a>&nbsp;";
			//echo "<a target=_blank href=ez_asset_bl.php?system_name=$inactive_host><img src=../images/asset_bl.png title='Black-list Asset' border=0 width=12px height=12px></a>&nbsp;&nbsp;";
		}
	}
	echo "</td></tr>";
}
echo "</table>";
// End of software compliance summary


// To display systems not audited for "n" days
?>
<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class='reportdata' style='color:red' width=100%><b>Systems not Audited in Last <?echo $AUDIT_EXPIRY;?> days</td>
</tr>
</table>

<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>
	<td class="reportheader">Asset Tag</td>
	<td class="reportheader">Hostname</td>	
	<td class="reportheader">Assigned To</td>	
	<td class="reportheader">Last Audited</td>
</td>
</tr>
<?

// Generate current unix time stamp
$today=mktime(23,59,0,date('m'),date('d'),date('Y'));

$url=$base_url."/api/ast_list_active_hosts.php?key=$API_KEY";
$slno=0;
if ($query = load_xml($url)){
	for($i=0;$i<count($query);$i++){
		
		$tag=$query->asset[$i]->tag;
		$hostname=$query->asset[$i]->hostname;
		$assignedto=$query->asset[$i]->assignedto;
		
		$sub_url_1=$base_url."/api/oa_audit_information.php?key=$API_KEY&hostname=$hostname";
		$sub_query_1 = load_xml($sub_url_1);		
		$last_audited=$sub_query_1->host[0]->last_audited;
		if (strlen($last_audited)>0){
			$last_audited=$last_audited*1;
			$print_date=date('d M Y',$last_audited);			
		}else{
			$print_date="Never Audited";
		}
		$diff=($today-$last_audited)/86400;
		$diff=round($diff,0);
		
		
		if ($diff>$AUDIT_EXPIRY){ 
			$slno=$slno+1;
			
			echo "<tr bgcolor=#F0F0F0>";
			if (strlen($tag)==1){$id="0000".$tag;}
			if (strlen($tag)==2){$id="000".$tag;}
			if (strlen($tag)==3){$id="00".$tag;}
			if (strlen($tag)==4){$id="0".$tag;}
			if (strlen($tag)==5){$id="".$tag;}
			
			echo "<td class='reportdata' width=70 ><a href=edit_asset_1.php?assetid=$tag>$ASSET_PREFIX-$id</a></td>";
			echo "<td class='reportdata'> $hostname</td>";
			echo "<td class='reportdata'> $assignedto</td>";						
			echo "<td class='reportdata' style='text-align: center;'>$print_date</td>";
		}	
	}
}
echo "<tr><td class=reportdata colspan=4 style='text-align: left;'>TOTAL : $slno</td></tr>";
echo "</table>";

?>