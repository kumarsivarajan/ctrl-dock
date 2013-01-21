<?
include_once("config.php");
if (!check_feature(50)){feature_error();exit;}

$query_type		=$_REQUEST["query_type"];
$query_status	=$_REQUEST["query_status"];
$query_name		=$_REQUEST["query_name"];

$url="agency_list.php?type=" . $query_type . "&name=" . $query_name . "&status=".$query_status;
if (strpos($_SERVER['HTTP_REFERER'],"summary_agencies")>0){
	$url=$_SERVER['HTTP_REFERER'];
}

?>

<table border=0 width=100% cellpadding="0" cellspacing="0" >
<tr>
	<td align=left><b><font face="Arial" color="#CC0000" size="2">PLANNED ACTIVITIES</font></b></td>
</tr>
</table>
<br>

<?if (check_feature(49)){?>
<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#EEEEEE>
<form method=POST action=pa_create.php>
<tr>
	<td>
	<label style="width: 450px;">Provide a name for the project/activity</label>		
	<input name="project" size="80" class=forminputtext>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Create New Activity" name="Submit" class=forminputbutton>
	</td>
</tr>
</form>
</table>
<?}?>


<br>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader width=70>ID</td>		
		<td class=reportheader>Project</td>		
		<td class=reportheader>Status</td>		
		<td class=reportheader width=100>Created On</td>		
		<td class=reportheader width=100>Scheduled Start</td>
		<td class=reportheader width=100>Scheduled End</td>		
		<td class=reportheader>Location</td>				
		<td class=reportheader colspan=4>Manage</td>		
</tr>

<?
$sql="select activity_id,project,action,action_by,action_date from poa_master order by activity_id DESC";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	echo "<tr>";
	
	$activity_id	=$row[0];
	$project		=$row[1];
	$action			=$row[2];
	$action_date	=date("d M Y H:i",$row[4]);
	$poa_id			=$row[5];
	$scheduled_start="";
	$scheduled_end	="";
	

	$sub_sql="select first_name,last_name from user_master where username='$row[3]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$action_by=$sub_row[0]." ".$sub_row[1];
	
	
	$sub_sql="select location,scheduled_start_date,scheduled_end_date from poa_information where activity_id='$activity_id' order by record_index DESC limit 1";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$location			=$sub_row[0];
	
	if($sub_row[1]>0 && $sub_row[2]>0){
		$scheduled_start	=date("d M Y H:i",$sub_row[1]);
		$scheduled_end		=date("d M Y H:i",$sub_row[2]);
	}

	$id=$poa_id;
	if(strlen($poa_id)<=0){$id=$activity_id;}	
	echo "<td class=reportdata style='text-align:center;'>$id</td>";
	echo "<td class=reportdata>$project</td>";
	echo "<td class=reportdata>$action</td>";	
	echo "<td class=reportdata style='text-align:center;'>$action_date</td>";
	echo "<td class=reportdata style='text-align:center;'>$scheduled_start</td>";
	echo "<td class=reportdata style='text-align:center;'>$scheduled_end</td>";
	echo "<td class=reportdata>$location</td>";	
	if($action=="DRAFT" || $action=="REJECTED"){
		echo "<td class=reportdata  style='text-align:center;' width=70><a href='pa_edit_1.php?activity_id=$activity_id'><font color=#0066CC><b>EDIT</b></font></a></td>";
		echo "<td class=reportdata  style='text-align:center;' width=70><a href='pa_pre_submit.php?activity_id=$activity_id'><font color=#009900><b>SUBMIT</a></td>";
	}elseif($action=="APPROVED"){
		echo "<td class=reportdata width=40>&nbsp;</td>";
		echo "<td class=reportdata width=40>&nbsp;</td>";
	}else{
		echo "<td class=reportdata width=40>&nbsp;</td>";
		echo "<td class=reportdata  style='text-align:center;' width=70><a href='pa_pre_req.php?activity_id=$activity_id'><font color=#009900><b>RE-QUEUE</a></td>";
	}
	
	echo "<td class=reportdata  style='text-align:center;' width=60><a target=_blank href='pa_view.php?activity_id=$activity_id'><font color=#666699><b>VIEW</b></font></a></td>";

	
	echo "</tr>";
}
?>
