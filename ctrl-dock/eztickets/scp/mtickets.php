<STYLE TYPE="text/css">
<?	include_once("css/style.css");?>
<?	include_once("css/main.css");?>
</STYLE>
<?
require('staff.inc.php');
require_once(INCLUDE_DIR.'class.ticket.php');
$track_id	=$_REQUEST['track_id'];
$action		=$_REQUEST['action'];
?>
<b>Parent Ticket ID : <?=$track_id;?></b>
<br>
<table border=0 width=100% cellspacing=3 cellpadding=0>
<?
if ($action=="dissolve"){
	echo "<br><br>All tickets that were merged under this parent ticket ID have been dissolved<br><br>";
	
	$sql="select ticket_id from isost_merge where track_id='$track_id'";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)){
		
		$merged_tickets=explode(",",$row[0]);			
		for ($i=0;$i<count($merged_tickets);$i++){
			$sql="update isost_ticket set track_id=0 where ticket_id='".$merged_tickets[$i]."'";
			$result = mysql_query($sql);
		}
	}
	
	$sql="delete from isost_merge where track_id='$track_id'";
	$result = mysql_query($sql);

	$sql="update isost_ticket set track_id=0 where ticket_id='$track_id'";
	$result = mysql_query($sql);
	
}else{
	$sql="select ticket_id from isost_merge where track_id='$track_id'";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)){
		$merged_tickets=explode(",",$row[0]);
		
		for ($i=0;$i<count($merged_tickets);$i++){
			echo "<tr><td bgcolor=#CCCCCC>";
			echo "Ticket ID : <b>$merged_tickets[$i]<b></td></tr>";
			$sub_sql="select helptopic,subject from isost_ticket where ticket_id='".$merged_tickets[$i]."'";
			$sub_result = mysql_query($sub_sql);
			$sub_row = mysql_fetch_row($sub_result);
			echo "<tr><td bgcolor=#FFFFFF>";
			echo "$sub_row[0] <br> $sub_row[1]";
			echo "</td></tr>";
		}
	}
	echo "<tr><td bgcolor=#FFFFFF><a href=mtickets.php?track_id=$track_id&action=dissolve><br><b>dissolve merge</a></td></tr>";
}
?>
	<tr><td bgcolor='#FFFFFF' align=center>
		<script language="Javascript">
			document.write('<a href="javascript:self.close()" onClick="opener.location.reload(true);">CLOSE THIS WINDOW</a>');
		</script>
	</td></tr>
</table>


<?
require_once(STAFFINC_DIR.$inc);
require_once(STAFFINC_DIR.'footer.inc.php');
?>

