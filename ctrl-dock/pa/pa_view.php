<?php 
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/css/default.css");

include_once("pa_approve.php");

if ($authorized==0){
	include_once("config.php");
	if(!check_feature(52)){feature_error();exit;}
	$activity_id	=$_REQUEST["activity_id"];
}

$sql="select a.project,a.action_by,a.action_date from poa_master a where a.activity_id='$activity_id'";
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


$sql="select activity_id,scheduled_start_date,scheduled_end_date,actual_start_date,actual_end_date,location,activity_description,activity_impact,activity_services,activity_verification,release_notes";
$sql.=" from poa_information where activity_id='$activity_id' order by record_index DESC limit 1";

$result = mysql_query($sql);
$record_count=mysql_num_rows($result);
if($record_count>0){
	while ($row = mysql_fetch_row($result)){
		$activity_id	=$row[0];

		if($row[1]>0 && $row[2]>0){
			$s_from			=date("d-M-Y H:i",$row[1]);
			$s_end			=date("d-M-Y H:i",$row[2]);
			$diff			=round((($row[2]-$row[1])/60),2);
			$s_window		=$s_from. " to " . $s_end . "<b> | ".$diff . " mins";
		}

		if($row[3]>0 && $row[4]>0){
			$a_from			=date("d-M-Y H:i",$row[3]);
			$a_end			=date("d-M-Y H:i",$row[4]);
			$diff			=round((($row[4]-$row[3])/60),2);
			$a_window		=$a_from. " to " . $a_end . "<b> | ".$diff . " mins";
		}
			
		
		$location		=$row[5];

		$activity_description	=$row[6];
		$activity_impact		=$row[7];
		$activity_services		=$row[8];
		$activity_verification	=$row[9];
		$release_notes		=$row[10];
	}
}
?>

<center>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td height=40 align=left><b><font face=Arial size=3>&nbsp;PLANNED ACTIVITY - <?=$activity_id;?></font></b></td>
	<td align=right><b><font face="Arial" color="#CC0000" size="1"><a href="javascript:window.print();"><font face=Arial size=1 color=#BBBBBB><b>PRINT</font></b></a></td>
</tr>
</table>


<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left' colspan=2>&nbsp;Summary</td></tr>
<tr>
	<td class=reportdata width=500>Project / Activity</td>
	<td class=reportdata width=500><b><?=$project;?></b></td>
</tr>
<tr>
	<td class=reportdata width=500>Initiated By</td>
	<td class=reportdata width=500><?=$action_by;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Initiated On</td>
	<td class=reportdata width=500><?=$action_date;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Scheduled Maintenance Window</td>
	<td class=reportdata width=500><?=$s_window;?></td>
</tr>
<tr>
	<td class=reportdata width=500>Actual Maintenance Window</td>
	<td class=reportdata width=500><?=$a_window?></td>
</tr>
<tr>
	<td class=reportdata width=500>Location Information</td>
	<td class=reportdata width=500><?=$location;?></td>
</tr>
</table>

<br>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=2>Description of the Activity</td>	
</tr>
<tr>
	<td class=reportdata colspan=2><?=nl2br($activity_description);?></td>	
</tr>
</table>
<br>

<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=2>Scope of Impact (Areas/Services/Customers potentially impacted)</td>	
</tr>
<tr>
	<td class=reportdata colspan=2><?=nl2br($activity_impact);?></td>	
</tr>
</table>
<br>

<br>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=2>Testing of Services after Implementation</td>	
</tr>
<tr>
	<td class=reportdata colspan=2><?=nl2br($activity_services);?></td>	
</tr>
</table>
<br>


<br>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=2>Verification of Activity (Information to verify that the activity has been completed successfully)</td>	
</tr>
<tr>
	<td class=reportdata colspan=2><?=nl2br($activity_verification);?></td>	
</tr>
</table>
<br>

<br>
<table border=0 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
        <td class=reportheader style='text-align:left' colspan=2>Release Notes</td>
</tr>
<tr>
        <td class=reportdata colspan=2><?=nl2br($release_notes);?></td>
</tr>
</table>
<br>


<?
// Detailed Activity Plan
$table="poa_activity_plan";
?>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=4>Detailed Activity Plan</td>
</tr>
<tr>		
		<td class=reportheader width=72 style='background-color: #BBBBBB'>Sl. No.</td>
		<td class=reportheader style='background-color: #BBBBBB'>Task</td>
		<td class=reportheader width=70 style='background-color: #BBBBBB'>Duration</td>		
		<td class=reportheader width=230 style='background-color: #BBBBBB'>Owner</td>				
</tr>
<?
$sql="select record_index,task_description,task_duration,task_owner,item_order";
$sql.=" from $table where activity_id='$activity_id' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;

while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$task_description	=$row[1];
	$task_duration		=$row[2];
	$task_owner			=$row[3];
	$item_order			=$row[4];
	
?>
	<tr>
		<td class=reportdata style='text-align:center'><?=$i;?></td>
		<td class=reportdata><?=$task_description;?></td>
		<td class=reportdata style='text-align:center'><?=$task_duration;?> mins</td>
		<td class=reportdata><?=$task_owner;?></td>
	</tr>
<?
$i++;
}
?>
</table>
<br>


<?
// Roll Back Plan
$table="poa_rollback_plan";
?>
<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr>
	<td class=reportheader style='text-align:left' colspan=4>Rollback Activity Plan</td>	
</tr>
<tr>
		<td class=reportheader width=72 style='background-color: #BBBBBB'>Sl. No.</td>
		<td class=reportheader style='background-color: #BBBBBB'>Task</td>
		<td class=reportheader width=70 style='background-color: #BBBBBB'>Duration</td>		
		<td class=reportheader width=230 style='background-color: #BBBBBB'>Owner</td>			
</tr>
<?
$sql="select record_index,task_description,task_duration,task_owner,item_order";
$sql.=" from $table where activity_id='$activity_id' GROUP BY task_description HAVING COUNT(task_description) = 1 order by item_order";
$result = mysql_query($sql);
$record_count=mysql_num_rows($result);

$i=1;

while ($row= mysql_fetch_row($result)){
	$record_index		=$row[0];
	$task_description	=$row[1];
	$task_duration		=$row[2];
	$task_owner			=$row[3];
	$item_order			=$row[4];
	
?>
	<tr>
		<td class=reportdata style='text-align:center'><?=$i;?></td>
		<td class=reportdata><?=$task_description;?></td>
		<td class=reportdata style='text-align:center'><?=$task_duration;?> mins</td>
		<td class=reportdata><?=$task_owner;?></td>
	</tr>
<?
$i++;
}
?>
</table>

<br>
<?
	include("pa_attachment_view.php");
?>
<br>
<center>
<?
// Activity Approval 
$table="poa_approval_history";
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
$sql.=" from poa_approval_history where activity_id='$activity_id' and action in ('APPROVED','REJECTED') order by item_order";

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
$sql.=" from poa_approval_history where activity_id='$activity_id' and action in ('ADDED','PENDING APPROVAL') order by item_order";
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