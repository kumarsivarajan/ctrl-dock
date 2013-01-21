<?
include_once("include/config.php");
include_once("include/css/default.css");
include_once("include/load_xml.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

// To display list of open tickets

?>



<table border=0 width=100% cellspacing=0 cellpadding=2>
<tr>
	<td class='reportdata' width=650><b>TICKETS</td>
	<td class='reportdata' style="text-align:right;height:20px;" width=40><a href='eztickets/scp/tickets.php' style="text-decoration:none;">details</a>
	<td class='reportdata' style="text-align:center; height:20px;" width=20><a href='eztickets/scp/tickets.php'><img border=0 src="images/history.gif"></a>
</tr>
</table>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<?
$url=$base_url."/api/tkt_count_summary.php?key=$API_KEY&staff=$username";
if ($query = load_xml($url)){
	for($i=0;$i<count($query);$i++){
		$open=$query->summary[$i]->open;
		$low=$query->summary[$i]->low;
		$normal=$query->summary[$i]->normal;
		$high=$query->summary[$i]->high;
		$emergency=$query->summary[$i]->emergency;
		$exception=$query->summary[$i]->exception;
		$staff=$query->summary[$i]->staff;
		$unassigned=$query->summary[$i]->unassigned;
	}

	echo "<tr>";
	$code_tabs=array();
	
	$bg_color="#999999";
	if($staff>0){$bg_color="#89B700";}
	$code_tabs[0]=$bg_color;
	echo "<td width=12% height=100 style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>MY TICKETS</b><br><br>";
	echo "<font size=6><b>$staff</b></td>";
	
	
	
	$bg_color="#999999";
	if($open>0){$bg_color="#666666";}
	$code_tabs[1]=$bg_color;
	echo "<td width=12% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>OPEN</b><br><br>";
	echo "<font size=6><b>$open</b></td>";

	
	$bg_color="#999999";	
	if($unassigned>0){$bg_color="#FFCC00";}
	$code_tabs[2]=$bg_color;
	echo "<td width=13% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>UN-ASSIGNED</b><br><br>";
	echo "<font size=6><b>$unassigned</b></td>";

	
	$bg_color="#999999";
	if($emergency>0){$bg_color="#CC0000";}
	$code_tabs[3]=$bg_color;
	echo "<td width=12% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>EMERGENCY</b><br><br>";
	echo "<font size=6><b>$emergency</b></td>";
	
	$bg_color="#999999";
	if($low>0){$bg_color="#FFFF66";}
	$code_tabs[4]=$bg_color;
	echo "<td width=12% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>LOW</b><br><br>";
	echo "<font size=6><b>$low</b></td>";
		
	$bg_color="#999999";
	if($normal>0){$bg_color="#82A0DF";}
	$code_tabs[5]=$bg_color;
	echo "<td width=13% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>NORMAL</b><br><br>";
	echo "<font size=6><b>$normal</b></td>";
	
	$bg_color="#999999";
	if($high>0){$bg_color="#FF6600";}
	$code_tabs[6]=$bg_color;
	echo "<td width=12% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>HIGH</b><br><br>";
	echo "<font size=6><b>$high</b></td>";
		
	$bg_color="#999999";
	if($exception>0){$bg_color="#00FFFF";}
	$code_tabs[7]=$bg_color;
	echo "<td width=13% style='text-align: center; background-color: #CCCCCC;font-family:Arial;font-size:10px;color:#333333'>";
	echo "<b>EXCEPTION</b><br><br>";
	echo "<font size=6><b>$exception</b></td>";

	echo "</tr>";
	
}

echo "<tr>";

for ($i=0;$i<count($code_tabs);$i++){
	$bgcolor=$code_tabs[$i];
	echo "<td style='text-align: center; background-color: $bgcolor;'></td>";
}
echo "</tr>";

echo "</table>";
?>