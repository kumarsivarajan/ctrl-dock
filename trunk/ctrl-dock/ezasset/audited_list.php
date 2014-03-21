<?
include_once("config.php");
include_once("searchasset.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

$sub_url_1=$base_url."/api/oa_audited_list.php?key=$API_KEY";
$sub_query_1 = load_xml($sub_url_1);

?>
	<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
	<tr>
		<td class='reportdata' style='color:black' width=100%><b>List of all audited systems</td>
	</tr>
	</table>

	<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
	<tr>
		<td class="reportheader">Hostname</td>	
		<td class="reportheader">Operating System</td>
		<td class="reportheader">Asset ID</td>	
		<td class="reportheader">Assigned To</td>	
		<td class="reportheader">Last Audited</td>
		<td class="reportheader">&nbsp;</td>			
	</td>
	</tr>


<?
for($i=0;$i<count($sub_query_1);$i++){
	$hostname	=$sub_query_1->host[$i]->hostname;
	$system_id	=$sub_query_1->host[$i]->system_id;
	$os			=$sub_query_1->host[$i]->os;
	$last_seen	=$sub_query_1->host[$i]->last_seen;
	$last_seen  =$last_seen+0;

	echo "<tr>";

	echo "<td class='reportdata'><a target=_blank href='../OA2/index.php/main/system_display/$system_id'>$hostname</a></td>";
	
	
	$sql="select a.assetid,b.first_name,b.last_name from asset a, user_master b where a.hostname='$hostname' and a.employee=b.username";
	$result = mysql_query($sql);
	$assetid="";
	$assigned_to="";
	while($row = mysql_fetch_row($result)){
		$tag=$row[0];
		$assetid="$ASSET_PREFIX-".str_pad($row[0], 5, "0", STR_PAD_LEFT);
		$assigned_to=$row[1]." ".$row[2];
	}
	
	echo "<td class='reportdata'> $os</td>";			
	echo "<td class='reportdata' style='text-align:center;'><a href=edit_asset_1.php?assetid=$tag>$assetid</a></td>";			
	echo "<td class='reportdata'> $assigned_to</td>";			
	echo "<td class='reportdata' style='text-align:center;'>".date('d M Y',$last_seen)."</td>";			
	echo "<td class='reportdata' style='text-align:center;'><a target=_blank href='del_system.php?id=$system_id'>Delete</a></td>";
	
	echo "</tr>";
}