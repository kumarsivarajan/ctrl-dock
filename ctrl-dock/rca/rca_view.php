<?php 
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/css/default.css");

include_once("rca_approve.php");

if ($authorized==0){
	include_once("config.php");
	if(!check_feature(51)){feature_error();exit;}
	$activity_id	=$_REQUEST["activity_id"];
}

$sql="select a.project,a.action_by,a.action_date from rca_master a where a.activity_id='$activity_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$project=$row[0];

$sub_sql="select first_name,last_name from user_master where username='$row[1]'";
$sub_result = mysql_query($sub_sql);
$sub_row = mysql_fetch_row($sub_result);
$action_by=$sub_row[0]." ".$sub_row[1];

$action_date="";
if(strlen($row[2])>0){
	$action_date	=date("d M Y H:i",$row[2]);
}

$submit_date	=$row[2];


$sql="select activity_id,open_date,attended_date,closure_date,description,symptoms,impact_analysis,ca_root_cause,ca_reason,ca_action,pa_action,recommendations,observations";
$sql.=" from rca_information where activity_id='$activity_id' order by record_index DESC limit 1";


$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	while ($row = mysql_fetch_row($result)){
		$activity_id	=$row[0];

		if($row[1]>0){			
			$open_date		=date("d-M-Y H:i",$row[1]);
		}
		if($row[2]>0){
			$attended_date	=date("d-M-Y H:i",$row[2]);
		}
		if($row[3]>0){
			$closure_date	=date("d-M-Y H:i",$row[3]);
		}
		
		$description		=$row[4];

		$symptoms			=$row[5];
		$impact_analysis	=$row[6];		
		$ca_root_cause		=$row[7];
		$ca_reason			=$row[8];
		$ca_action			=$row[9];
		$pa_action			=$row[10];
		$recommendations	=$row[11];
		$observations		=$row[12];
	}
}
?>


<center>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor="#F5F5F5">
<tr>
	<td height=40 align=left><b><font face=Arial size=3>&nbsp;ROOT CAUSE ANALYSIS</font></b></td>
	<td align=right><b><font face="Arial" color="#CC0000" size="1"><a href=javascript:window.print();><font face=Arial size=1 color=#BBBBBB><b>PRINT</font></b></a></td>
</tr>
</table>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor="#F5F5F5">
<tr><td class=reportheader style='text-align:left' colspan=2>&nbsp;Summary</td></tr>
<tr>
	<td class=reportdata width=300>Ticket ID</td>
	<td class=reportdata><?=$activity_id;?></td>
</tr>
<tr>
	<td class=reportdata width=300>Description</td>
	<td class=reportdata><?=$project;?></td>
</tr>
<tr>
	<td class=reportdata width=300>Submitted By</td>
	<td class=reportdata ><?=$action_by;?></td>
</tr>
<tr>
	<td class=reportdata width=300>Submitted On</td>
	<td class=reportdata ><?=$action_date;?></td>
</tr>
</table>
<br>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor="#F5F5F5">
<tr>
	<td class=reportdata width=300><b>Incident On</td>
	<td class=reportdata ><?=$open_date;?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Attended On</td>
	<td class=reportdata ><?=$attended_date;?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Closure On</td>
	<td class=reportdata ><?=$closure_date;?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Description</td>
	<td class=reportdata ><?=nl2br($description);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Symptoms Observed</td>
	<td class=reportdata ><?=nl2br($symptoms);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Impact on systems, services</td>
	<td class=reportdata><?=nl2br($impact_analysis);?></td>
</tr>
<tr><td colspan=2 class=reportheader style='text-align:left'>&nbsp;Root Cause Information</td></tr>
<tr>
	<td class=reportdata width=300><b>Analysis</td>
	<td class=reportdata ><?=nl2br($ca_root_cause);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Background Information</td>
	<td class=reportdata ><?=nl2br($ca_reason);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Remedial Action</td>
	<td class=reportdata><?=nl2br($ca_action);?></td>
</tr>
<tr><td colspan=2 class=reportheader style='text-align:left'>&nbsp;Next Steps</td></tr>
<tr>
	<td class=reportdata width=300><b>Short Term Preventive Action</td>
	<td class=reportdata><?=nl2br($pa_action);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Long Term Recommendations</td>
	<td class=reportdata><?=nl2br($recommendations);?></td>
</tr>
<tr>
	<td class=reportdata width=300><b>Other Observations if any</td>
	<td class=reportdata><?=nl2br($observations);?></td>
</tr>
</table>
<br>
<?
	include("rca_attachment_view.php");
?>
<br>
<center>
<?
// Activity Approval 
$table="rca_approval_history";
?>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=6>Activity Approval</td>	
</tr>
<tr>		
		<td class=reportheader width=50 style='background-color: #BBBBBB'>Sl. No.</td>
		<td class=reportheader width=350 style='background-color: #BBBBBB'>Approver Name</td>
		<td class=reportheader width=200 style='background-color: #BBBBBB'>Approver E-Mail</td>
		<td class=reportheader width=100 style='background-color: #BBBBBB'>Status</td>						
		<td class=reportheader width=100 style='background-color: #BBBBBB'>Date</td>
		<td class=reportheader width=200 style='background-color: #BBBBBB'>Comments</td>						
</tr>
<?
$record_index=0;
$sql="select record_index,approver_name,approver_email,item_order,action,action_date,comments";
$sql.=" from rca_approval_history where activity_id='$activity_id' and action in ('APPROVED','REJECTED') order by item_order";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;

while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$approver_name		=$row[1];
	$approver_email		=$row[2];
	$item_order			=$row[3];
	$action				=$row[4];
	if($action=="APPROVED" || $action=="REJECTED"){
		$action_date		=date("d-M-Y H:i",$row[5]);
		$comments			=$row[6];
	}
?>
	<tr>
		<td class=reportdata style='text-align:center'><?=$i;?></td>
		<td class=reportdata><?=$approver_name;?></td>		
		<td class=reportdata><?=$approver_email;?></td>
		<td class=reportdata><?=$action;?></td>
		<td class=reportdata><?=$action_date;?></td>
		<td class=reportdata><?=$comments;?></td>
	</tr>
<?
$i++;
}

// Fetch list of records which are pending for approval
$sql="select record_index,approver_name,approver_email,item_order";
$sql.=" from rca_approval_history where activity_id='$activity_id' and action in ('ADDED','PENDING APPROVAL') order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
while ($row= mysql_fetch_row($result)){
	$approver_name		=$row[1];
	$approver_email		=$row[2];
?>
	<tr>
		<td class=reportdata style='text-align:center'><?=$i;?></td>
		<td class=reportdata><?=$approver_name;?></td>		
		<td class=reportdata><?=$approver_email;?></td>
		<td class=reportdata>Pending Approval</td>
		<td class=reportdata>&nbsp;</td>
		<td class=reportdata>&nbsp;</td>
	</tr>
<?
	$i++;
	}
?>
</table>
