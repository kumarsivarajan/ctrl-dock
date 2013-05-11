<?php 

include("config.php"); 

$hostname	=$_REQUEST["hostname"];
$hostdesc	=$_REQUEST["desc"];
$records	=$_REQUEST["records"];

if(strlen($records)<=0)
{
	$records=60;
}

$query_host_master = sprintf("SELECT host_id 
 		FROM hosts_master 
		WHERE hostname='%s'",$hostname);

$result = mysql_query($query_host_master);
$row	= mysql_fetch_row($result);
$host_id=$row[0];


?>

<?php
if(isset($_REQUEST['submit']))
{
	$timedetail = $_REQUEST['txttime'];
	if	  ($timedetail == '3'){$timedetail = date("Y-m-d H:i:s", time() - 10800);}
	elseif($timedetail == '6'){$timedetail = date("Y-m-d H:i:s", time() - 21600);}
	elseif($timedetail == '9'){$timedetail = date("Y-m-d H:i:s", time() - 32400);}
	elseif($timedetail == '24'){$timedetail = date("Y-m-d H:i:s", time() - 86400);}
	elseif($timedetail == '168'){$timedetail = date("Y-m-d H:i:s", time() - 604800);}
	elseif($timedetail == '360'){$timedetail = date("Y-m-d H:i:s", time() - 1296000);}
	else{$timedetail = '';}
	
	$fromdate	  	= $_REQUEST['txtfrmdate'];
	$fromdate		= date_to_int($fromdate )+ ($_REQUEST['from_time_hh']*3600) + ($_REQUEST['from_time_mm']*60);
	
	$todate	  = $_REQUEST['txttodate'];
	$todate		= date_to_int($todate) + ($_REQUEST['to_time_hh']*3600) + ($_REQUEST['to_time_mm']*60);
	
	$hostid = $_REQUEST['txthostid'];
	$hostname = $_REQUEST['txthostname'];
}
?>

<title>Load / Performance Statistics : <?=$hostname;?></title>

<table border=0 width=100% cellpadding="2" cellspacing="0" bgcolor=#E5E5E5 >
  <tr>
    <td width="90%" style="border-style: none; border-width: medium" align=left colspan=1>
		<font face=Arial size=2 color=#CC0000><b>HOST / FQDN MONITORING : <?=$hostname;?> <?=$hostdesc;?></b></font>
	</td>
	<td width=10% class='reportdata' style='text-align:right;'>
		<a href=../dash/dash_see_more_hosts.php>BACK</a>
	</td>
  </tr>
</table>

<table class="reporttable" width=100% border=0>
<tr>


	<td width=7% class='reportdata' style='text-align:center;'>
		<form name="frm" id="frmid" action="show_host_details.php" method="post">
			<tr>
				<td class='tdformlabel'>Time</td>
				<td><select name="txttime" id="txttime" class=formselect>
					<option value=""></option>
					<option value="3">3 Hours</option>
					<option value="6">6 Hours</option>
					<option value="9">9 Hours</option>
					<option value="24">1 Day</option>
					<option value="168">7 Days</option>
					<option value="360">15 Days</option>
					</select>
				</td>
				
				<td class='tdformlabel'>From Date</td>
				<td><input id="txtfrmdate" class=forminputtext name="txtfrmdate" value=""
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>

				<select size='1' class=formselect name="from_time_hh">
				<?
					for($i=0;$i<24;$i++){
						if ($i<10){$i="0".$i;}
						echo "<option value='$i'>$i</option>";
					}
				?>
				</select>
				<select size='1' class=formselect name="from_time_mm">
				<?
					for($i=0;$i<60;$i=$i+5){
						if ($i<10){$i="0".$i;}
						echo "<option value='$i'>$i</option>";
					}
					echo "<option value='59'>59</option>";
				?>

				</select>
				</td>
				
				<td class='tdformlabel'>To Date</td>
				<td><input class=forminputtext id="txttodate" name="txttodate" value=""
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
                <a href="#" onclick="event.cancelBubble=true;calendar(getObj('txttodate')); return false;"></a>
				<select size=1 class=formselect name="to_time_hh">
				<?
					for($i=0;$i<24;$i++){
						if ($i<10){$i="0".$i;}
						echo "<option value='$i'>$i</option>";
					}
				?>
				</select>
				<select size=1 class=formselect name="to_time_mm">
				<?
					for($i=0;$i<60;$i=$i+5){
						if ($i<10){$i="0".$i;}
						echo "<option value='$i'>$i</option>";
					}
					echo "<option value='59'>59</option>";
				?>
				</select>
				</td>
				
				<td><input type="hidden" name="txthostid" id="txthostid" value="<?php if(isset($_REQUEST['txthostid'])) { echo $_REQUEST['txthostid']; } else { echo $host_id; } ?>" />
				
				<input type="hidden" name="txthostname" value="<?php echo $hostname; ?>" /></td>
				
				<td><input type="submit" name="submit" id="txtsubmit" value="submit" /></td>
		
			</tr>
		</form>
	</td>
</tr>

</table>

<?
if(isset($_REQUEST['submit'])){
?>

<?
$timedetail = strtotime($timedetail);
if($timedetail!=''){
	$sql="select timestamp,min,avg,max from hosts_nw_log where host_id='$hostid' and timestamp >= '$timedetail' order by record_id desc";
}
elseif($fromdate!='' && $todate!='')
{
	$sql="select timestamp,min,avg,max from hosts_nw_log where host_id='$hostid' and timestamp BETWEEN '$fromdate' and '$todate' order by record_id desc";
}

$log_url="ping_history.php?hostname=$hostname&fromdate=$fromdate&todate=$todate&timedetail=$timedetail";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
$record_count;
if ($record_count>0)
{
?>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5 id="txtfresult">
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>NETWORK RESPONSE</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:center; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('<?=$log_url;?>','Ping Statistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>
<?


	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
	
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$graph_data[$i]="["."$timestamp,$row[1],$row[2],$row[3]"."]";
		$i++;
	}

	$graph_data=implode(",",$graph_data);

	$x_axis_label="Time";
	$y_axis_label="Average Ping m/s";
	$graph_title="Network Response";
	$graph_name="ping_history";
	$graph_width="99%";
	$graph_height="300px";
	include("host_graph.php");
?>
</td></tr>
</table>
<?
}
else
{
	?>
	<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>NETWORK RESPONSE</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:center; height:20px;" width=20><a href='javascript:void(0);','Ping Statistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata><font style="color:#FF0000;">No Data to display Network Response Graph</font></td></tr>
<?
}
?>






<? 
if($timedetail!='')
{
$sql = "select timestamp,cpu_user,cpu_system,mem_utilization from hosts_nw_snmp_log where host_id='$hostid' and timestamp >= '$timedetail' order by record_id desc";
}
elseif($fromdate!='' && $todate!='')
{
$sql = "select timestamp,cpu_user,cpu_system,mem_utilization from hosts_nw_snmp_log where host_id='$hostid' and timestamp BETWEEN '$fromdate' and '$todate' order by record_id desc";
}

$log_url="snmp_history.php?hostname=$hostname&fromdate=$fromdate&todate=$todate&timedetail=$timedetail";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
$record_count;
if ($record_count>0){
?>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>RESOURCE UTILIZATION</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20><a href='javascript:void(0);'  onclick="javascript:window.open('<?=$log_url;?>','SNMPStatistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=600,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>

<?
	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$cpu=$row[1]+$row[2];
		$mem=$row[3];
		
		$graph_data[$i]="["."$timestamp,$cpu,$mem"."]";
		$graph_data[$i];
		$i++;
	}
	$graph_data=implode(",",$graph_data);
	$graph_data;

	$x_axis_label="Time";
	$y_axis_label="% Utilization";
	$graph_title="Resource Utilization";
	$graph_name="resource_utilization";
	$graph_width="99%";
	$graph_height="300px";
	include("snmp_graph.php");
?>
</td></tr>
</table>
<?
}
else
{
	?>
	<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>RESOURCE UTILIZATION</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20><a href='javascript:void(0);','SNMPStatistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=600,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata><font style="color:#FF0000">No Data to display Resource Utilization Graph</font></td></tr>
<?
}
?>

<!-- SERVICE AVAILABILITY GRAPH -->
<?

$sql 	= "SELECT port,description FROM hosts_service WHERE enabled=1 and host_id='$hostid' order by description";
$result = mysql_query($sql);

$record_count=mysql_num_rows($result);

if ($record_count>0){
$log_url="svc_history.php?hostname=$hostname&fromdate=$fromdate&todate=$todate&timedetail=$timedetail";
?>



<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>SERVICE AVAILABILITY</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:left; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('<?=$log_url;?>','Service Status History','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>

<tr><td colspan=2 class=reportdata style="text-align:center;" >
<?
	$graph_data	=array();
	$i=0;

	while ($row = mysql_fetch_row($result)){
		$port           =$row[0];
		$description    =$row[1];

		if($timedetail!='')
		{
			$sub_sql = "SELECT a.svc_status,a.timestamp FROM hosts_service_log a WHERE a.host_id='$hostid' AND a.port='$port' and timestamp >= '$timedetail' order by record_id desc";
		
		}
		elseif($fromdate!='' && $todate!='')
		{
			$sub_sql = "SELECT a.svc_status,a.timestamp FROM hosts_service_log a WHERE a.host_id='$hostid' AND a.port='$port' and timestamp BETWEEN '$fromdate' and '$todate' order by record_id desc";
		}
		

		$sub_result = mysql_query($sub_sql);
		$record_count=mysql_num_rows($sub_result);
		if($record_count=='0')
		{
			echo "No Data to display Service Availability Graph";
			exit;
		}
		$up_count=0;
		while ($sub_row = mysql_fetch_row($sub_result)){
			if($sub_row[0]==1){$up_count++;}
		}
		
		$svc_availability=($up_count/$record_count)*100;
		$svc_availability=round($svc_availability,1);
		
		$graph_data[$i]="['"."$description"."',".$svc_availability."]";
		$i++;
	}

	$graph_data=implode(",",$graph_data);

	$graph_title="Service Availability";
	$graph_name="service_availability";
	include("all_service_graph.php");
?>
</td></tr>
</table>
<?
}
}else{
                               
$timedetail_1 = date("Y-m-d H:i:s", time() - 10800);
$timedetail_1 = strtotime($timedetail_1);

$sql="select timestamp,min,avg,max from hosts_nw_log where host_id='$host_id' and timestamp >= '$timedetail_1' order by record_id desc";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

if ($record_count>0)
{
?>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5>

<tr>
	
	<td class='reportheader' style="text-align:left; height:20px;" width=960>NETWORK RESPONSE</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:center; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('ping_history.php?hostname=<?=$hostname; ?>&records=<?=$records;?>','Ping Statistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>
<?


	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$graph_data[$i]="["."$timestamp,$row[1],$row[2],$row[3]"."]";
		//$graph_data[$i];
		$i++;
	}

	$graph_data=implode(",",$graph_data);

	$x_axis_label="Time";
	$y_axis_label="Average Ping m/s";
	$graph_title="Network Response";
	$graph_name="ping_history";
	$graph_width="99%";
	$graph_height="300px";
	include("host_graph.php");
?>
</td></tr>
</table>
<?
}
else
{
	?>
	<table class="reporttable" width=100% cellspacing=0 cellpadding=5>

<tr>
	
	<td class='reportheader' style="text-align:left; height:20px;" width=960>NETWORK RESPONSE</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:center; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('ping_history.php?hostname=<?=$hostname; ?>&records=<?=$records;?>','Ping Statistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata><font style="color:#CCCCCC;">No Data to display the Network Response Graph</font></td></tr>
<?
}
						
?>






<? 
						
$sql = "select timestamp,cpu_user,cpu_system,mem_utilization from hosts_nw_snmp_log where host_id='$host_id' and timestamp >= '$timedetail_1' order by record_id desc";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

if ($record_count>0){
?>

<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>RESOURCE UTILIZATION</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20><a href='javascript:void(0);'  onclick="javascript:window.open('snmp_history.php?hostname=<?=$hostname;?>&records=<?=$records;?>','SNMPStatistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=600,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata>

<?
	$graph_data	=array();
	$i=0;
	while ($row = mysql_fetch_row($result)){
		$YYYY	=date("Y",$row[0]);
		$mm		=date("n",$row[0])-1;
		$dd		=date("d",$row[0]);
		$time	=date("H,i,s",$row[0]);
		$timestamp="$YYYY,$mm,$dd,$time";
		$timestamp="new Date(".$timestamp.")";
		
		$cpu=$row[1]+$row[2];
		$mem=$row[3];
		
		$graph_data[$i]="["."$timestamp,$cpu,$mem"."]";
		$graph_data[$i];
		$i++;
	}
	$graph_data=implode(",",$graph_data);

	$x_axis_label="Time";
	$y_axis_label="% Utilization";
	$graph_title="Resource Utilization";
	$graph_name="resource_utilization";
	$graph_width="99%";
	$graph_height="300px";
	include("snmp_graph.php");
?>
</td></tr>
</table>
<?
}
else
{
	?>
	<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>RESOURCE UTILIZATION</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20><a href='javascript:void(0);'  onclick="javascript:window.open('snmp_history.php?hostname=<?=$hostname;?>&records=<?=$records;?>','SNMPStatistics','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=600,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>
<tr><td colspan=2 class=reportdata><font style="color:#CCCCCC;">No Data to Display Resource Uitilization Graph</font></td></tr>
<?
}
				
?>

<!-- SERVICE AVAILABILITY GRAPH -->
<?

$sql 	= "SELECT port,description FROM hosts_service WHERE enabled=1 and host_id='$host_id' order by description";
$result = mysql_query($sql);

$record_count=mysql_num_rows($result);
if ($record_count>0){
?>
<table class="reporttable" width=100% cellspacing=0 cellpadding=5>
<tr>
	<td class='reportheader' style="text-align:left; height:20px;" width=960>SERVICE AVAILABILITY</td>
	<td class='reportheader' style="text-align:right; height:20px;" width=20>LOGS</td>
	<td class='reportheader' style="text-align:left; height:20px;" width=20><a href='javascript:void(0);' onclick="javascript:window.open('svc_history.php?hostname=<?=$hostname;?>&records=<?=$records;?>','Service Status History','status=0,toolbar=0,menubar=0,scrollbars=1,location=0,resizable=0,width=500,height=800');">
	<img border=0 src="images/history.gif"></img></a>
	</td>
</tr>

<tr><td colspan=2 class=reportdata style="text-align:left;">
<?
	$graph_data	=array();
	$i=0;

	while ($row = mysql_fetch_row($result)){
		$port           =$row[0];
		$description    =$row[1];

		$sub_sql = "SELECT a.svc_status,a.timestamp FROM hosts_service_log a WHERE a.host_id='$host_id' AND a.port='$port' AND timestamp >= '$timedetail_1' order by record_id desc";
		
		$sub_result = mysql_query($sub_sql);
		$record_count_1=mysql_num_rows($sub_result);
		if($record_count_1=='0'){
			?><font style="color:#CCCCCC;">No Data to display the Service Availability Graph</font><?
			exit;
		}else{	
		$up_count=0;
		while ($sub_row = mysql_fetch_row($sub_result)){
			if($sub_row[0]==1){$up_count++;}
		}
		
		$svc_availability=($up_count/$record_count_1)*100;
		$svc_availability=round($svc_availability,1);
		
		$graph_data[$i]="['"."$description"."',".$svc_availability."]";
		$i++;
		}
	}

	$graph_data=implode(",",$graph_data);

	$graph_title="Service Availability";
	$graph_name="service_availability";
	include("all_service_graph.php");
?>
</td></tr>
</table><!-- SERVICE AVAILABILITY GRAPH ENDS -->
<?
}
}
?>

			