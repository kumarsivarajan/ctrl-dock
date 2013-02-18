<?
include_once("config.php");
if (!check_feature(48)){feature_error();exit;}

$query_type		=$_REQUEST["query_type"];
$query_status	=$_REQUEST["query_status"];
$query_name		=$_REQUEST["query_name"];

if (strpos($_SERVER['HTTP_REFERER'],"summary_agencies")>0){
	$url=$_SERVER['HTTP_REFERER'];
}

?>
<center>

<table border=0 width=100% cellpadding="0" cellspacing="0" >
<tr>
	<td align=left><b><font face="Arial" color="#CC0000" size="2">ROOT CAUSE ANALYSIS (RCA) ARCHIVES</font></b></td>
</tr>
</table>
<br>

<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader width=70>Ticket ID</td>				
		<td class=reportheader>Summary</td>
		<td class=reportheader width=100>Incident On</td>
		<td class=reportheader width=150>Status</td>
		<td class=reportheader colspan=3>Manage</td>		
</tr>

<?
$sql="select activity_id,project,action,action_by,action_date from rca_master order by activity_id DESC";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	echo "<tr>";
	
	$activity_id	=$row[0];
	$project		=$row[1];
	$action			=$row[2];
	$action_date	=date("d M Y H:i",$row[4]);
	$rca_id			=$row[5];
	

	$sub_sql="select first_name,last_name from user_master where username='$row[3]'";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	$action_by=$sub_row[0]." ".$sub_row[1];
	
	
	$sub_sql="select open_date from rca_information where activity_id='$activity_id' order by record_index DESC limit 1";
	$sub_result = mysql_query($sub_sql);
	$sub_row = mysql_fetch_row($sub_result);
	
	if($sub_row[0]>0){
		$open_date			=date("d M Y H:i",$sub_row[0]);
	}

	$id=$rca_id;
	if(strlen($rca_id)<=0){$id=$activity_id;}	
	echo "<td class=reportdata style='text-align:center;'><a href=../eztickets/scp/tickets.php?id=$activity_id>$activity_id</a></td>";
	echo "<td class=reportdata>$project</td>";
	echo "<td class=reportdata>$open_date</td>";	
	echo "<td class=reportdata>$action</td>";	
	
	if($action=="DRAFT" || $action=="REJECTED"){
	echo "<td class=reportdata  style='text-align:center;' width=70><a href='rca_edit_1.php?activity_id=$activity_id'><font color=#0066CC><b>EDIT</b></font></a></td>";
	echo "<td class=reportdata  style='text-align:center;' width=70><a href='rca_pre_submit.php?activity_id=$activity_id'><font color=#009900><b>SUBMIT</a></td>";
	
	}elseif($action=="PENDING APPROVAL"){
	
		echo "<td class=reportdata  style='text-align:center;' width=70> </td>";
		
		
		$sub_sql="select action_date from rca_master where activity_id='$activity_id'";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$submit_date=$sub_row[0];
		
		$sub_sql="select approver_email from rca_approval_history where activity_id='$activity_id' and action in ('PENDING APPROVAL')";
		$sub_result = mysql_query($sub_sql);
		$sub_row = mysql_fetch_row($sub_result);
		$approver_email		=$sub_row[0];
		
		echo "<td class=reportdata  style='text-align:center;' width=70><a href='rca_pre_req.php?activity_id=$activity_id&email=$approver_email'><font color=#009900><b>RE-QUEUE</a></td>";
	}else{
		echo "<td class=reportdata width=40>&nbsp;</td>";
		echo "<td class=reportdata width=40>&nbsp;</td>";
	}
	echo "<td class=reportdata  style='text-align:center;' width=70><a target=_blank href='rca_view.php?activity_id=$activity_id'><font color=#666699><b>VIEW</b></font></a></td>";

	
	echo "</tr>";
}
?>
</table>
