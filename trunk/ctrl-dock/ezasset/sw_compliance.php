<?
include_once("config.php");

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
	for($i=0;$i<count($query);$i++){
		$id=$query->software[$i]->id;
		if(strlen($id)>0){
		$title=$query->software[$i]->title;
		$license_purchased=$query->software[$i]->license_purchased;
		$software_used=$query->software[$i]->software_used;
		$slno=$i+1;
		echo "<tr bgcolor=#F0F0F0>";
		echo "<td class='reportdata' style='text-align: center;' width=30>$slno</td>";
		echo "<td class='reportdata' >$title</td>";
		if($license_purchased<0){
			echo "<td class='reportdata' style='text-align: center;' width=60>NA</td>";
		}else{
			echo "<td class='reportdata' style='text-align: center;' width=60>$license_purchased</td>";
		}
		
		$sub_url_1=$base_url."/api/oa_list_hosts_by_sw.php?key=$API_KEY&id=$id";
		$active_count=0;
		$inactive_count=0;
		
		$sw_a_host="LIST OF ACTIVE HOSTS FOR $title<br><br>";
		$sw_ia_host="LIST OF IN-ACTIVE HOSTS FOR $title<br><br>";
		
		if ($sub_query_1 = load_xml($sub_url_1)){
			for($j=0;$j<count($sub_query_1);$j++){
				$hostname=$sub_query_1->host[$j]->hostname;
				
				$sub_url_2=$base_url."/api/ast_information.php?key=$API_KEY&hostname=$hostname";
				$sub_query_2 = load_xml($sub_url_2);
				$status=$sub_query_2->asset[0]->status;
				if($status=="Active"){
					$active_count++;
					$sw_a_host.="   $hostname   ";
				}else{
					$inactive_count++;
					$inactive_host_list[$inactive_host_count]=$hostname;
					$inactive_host_count++;
					$sw_ia_host.="   $hostname   ";
				}
			}			
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

$inactive_host_list=array_unique($inactive_host_list);
$inactive_count=count($inactive_host_list);

if ($inactive_count>0){
	echo "<tr bgcolor=#E0E0E0><td class='reportdata' colspan=7 width=100%>";
	echo "<b>The following hosts are reporting, but could not be mapped in the Physical Asset Database. Verify and correct the same to ensure accuracy of the compliance data.</b><br><br>";
	for($i=0;$i<count($inactive_host_list);$i++){
		$inactive_host=$inactive_host_list[$i];
		if(strlen($inactive_host)>0){
			echo "<a target=_blank href=ez_sys_info.php?system_name=$inactive_host>$inactive_host</a>&nbsp;";
			echo "<a target=_blank href=ez_asset_bl.php?system_name=$inactive_host><img src=../images/asset_bl.png title='Black-list Asset' border=0 width=12px height=12px></a>&nbsp;&nbsp;";
		}
	}
	echo "</td></tr>";
}
echo "</table>";
// End of software compliance summary
?>