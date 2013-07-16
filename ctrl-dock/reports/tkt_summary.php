<?php
if ($_REQUEST["xls"]==1){
	$timestamp=date('d-m-Y-H-i-s',mktime());
	$filename="TICKET_STATISTICS_".$timestamp.".xls";
	
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=$filename"); 
}

include_once("config.php");


//if (!check_feature(31)){feature_error();exit;}

?>

<center>
<?
if ($_REQUEST["xls"]!=1){
	include_once("tkt_summary_query.php");
}

if ($_REQUEST['start_date'] && $_REQUEST['end_date']){
	$start_date	=report_date($_REQUEST['start_date'],0,0,0);
	$end_date	=report_date($_REQUEST['end_date'],23,59,59);
}else{
	$start_date = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	$end_date   = mktime(23,59,59,date("m"),date("d"),date("Y"));
}

$display_start_date	=date('d-m-Y',$start_date);
$display_end_date	=date('d-m-Y',$end_date);

$dept_id=$_REQUEST['dept_id'];
if ($dept_id>0){
$sql = "select dept_name from isost_department where dept_id='$dept_id'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$display_dept_name=$row[0];
}else{
	$display_dept_name="ALL DEPARTMENTS";
}

$ticket_type_id	= $_REQUEST['ticket_type_id'];
$priority_id	= $_REQUEST['priority_id'];
$status			= $_REQUEST['status'];
?>


<br>
<table border="0" cellpadding="0" cellspacing="0" width=100%>
<tr>
	<td class=reportdata>
	<b>Reported Generated From : <?=$display_start_date?></b>
	&nbsp;&nbsp;&nbsp;
	<b>To : <?=$display_end_date?></b>
	</td>
	<td class=reportdata>&nbsp;</td>	
	<?if($_REQUEST["xls"]!=1){?>
	<td class=reportdata style="text-align:right" width=100><a target=_new href='tkt_summary.php?xls=1&start_date=<?=$_REQUEST['start_date']?>&end_date=<?=$_REQUEST['end_date']?>&dept_id=<?=$dept_id?>'><b>Export to Excel</a></td>
	<?}?>
</tr>
</table>
<br>


<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
<?

$main_sql="select ticket_type_id,priority_id,UNIX_TIMESTAMP(created)";
$main_sql.=" from isost_ticket where UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and track_id!=999999";
if($dept_id>0){
	$main_sql.=" and dept_id='$dept_id' ";
}else{
	$main_sql.=" and dept_id>0";
}


$sub_result 	= mysql_query($main_sql);
$ticket_count	= mysql_num_rows($sub_result);
$t_ticket_count	=$t_ticket_count+$ticket_count;

$sub_sql		=$main_sql." and status='open'";
$sub_result 	= mysql_query($sub_sql);
$open_count		= mysql_num_rows($sub_result);
$t_open_count	=$t_open_count+$open_count;
	
$sub_sql		=$main_sql." and status='closed'";
$sub_result 	= mysql_query($sub_sql);
$close_count	= mysql_num_rows($sub_result);
$t_close_count	=$t_close_count+$close_count;
	
	
	
$sub_sql		=$main_sql." and ticket_type_id='1'";
$sub_result 	= mysql_query($sub_sql);
$i_count		= mysql_num_rows($sub_result);
$t_i_count		=$t_i_count+$i_count;

$sub_sql		=$main_sql." and ticket_type_id='2'";
$sub_result 	= mysql_query($sub_sql);
$p_count		= mysql_num_rows($sub_result);
$t_p_count		=$t_p_count+$p_count;
	
	
$sub_sql		=$main_sql." and ticket_type_id='3'";
$sub_result 	= mysql_query($sub_sql);
$c_count		= mysql_num_rows($sub_result);
$t_c_count		=$t_c_count+$c_count;
	
$sub_sql		=$main_sql." and ticket_type_id='4'";
$sub_result 	= mysql_query($sub_sql);
$s_count		= mysql_num_rows($sub_result);
$t_s_count		=$t_s_count+$s_count;




$sub_sql		=$main_sql." and priority_id='5'";
$sub_result 	= mysql_query($sub_sql);
$excpt_count= mysql_num_rows($sub_result);
$t_excpt_count		=$t_excpt_count+$excpt_count;

$sub_sql		=$main_sql." and priority_id='4'";
$sub_result 	= mysql_query($sub_sql);
$emergency_count= mysql_num_rows($sub_result);
$t_emergency_count		=$t_emergency_count+$emergency_count;
	
$sub_sql		=$main_sql." and priority_id='3'";
$sub_result 	= mysql_query($sub_sql);
$high_count		= mysql_num_rows($sub_result);
$t_high_count		=$t_high_count+$high_count;

$sub_sql		=$main_sql." and priority_id='2'";
$sub_result 	= mysql_query($sub_sql);
$normal_count		= mysql_num_rows($sub_result);
$t_normal_count		=$t_normal_count+$normal_count;

$sub_sql		=$main_sql." and priority_id='1'";
$sub_result 	= mysql_query($sub_sql);
$low_count		= mysql_num_rows($sub_result);
$t_low_count		=$t_low_count+$low_count;

?>

<tr>
	<td class="reportdata" style="text-align:center;background:#EBEBEB" width=10%><b>Open<br><br><?=$t_open_count?></td>
	<td class="reportdata" style="text-align:center;background:#EBEBEB" width=9%><b>Closed<br><br><?=$t_close_count?></td>	
	
	<td class="reportdata" style="text-align:center;background:#C0C0C0" width=9%><b>Incident<br><br><?=$t_i_count?></td>
	<td class="reportdata" style="text-align:center;background:#C0C0C0" width=9%><b>Problem<br><br><?=$t_p_count?></td>	
	<td class="reportdata" style="text-align:center;background:#C0C0C0" width=9%><b>Change Request<br><br><?=$t_c_count?></td>	
	<td class="reportdata" style="text-align:center;background:#C0C0C0" width=9%><b>Service Request<br><br><?=$t_s_count?></td>	
	

	<td class="reportdata" style="text-align:center;background:#CC0000" width=9%><b>Emergency<br><br><?=$t_emergency_count?></td>	
	<td class="reportdata" style="text-align:center;background:#FF6600" width=9%><b>High<br><br><?=$t_high_count?></td>	
	<td class="reportdata" style="text-align:center;background:#82A0DF" width=9%><b>Normal<br><br><?=$t_normal_count?></td>		
	<td class="reportdata" style="text-align:center;background:#FFFF66" width=9%><b>Low<br><br><?=$t_low_count?></td>
	<td class="reportdata" style="text-align:center;background:#00FFFF" width=9%><b>Exceptions<br><br><?=$t_excpt_count?></td>	
	
</table>
<br>

<?

$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created) as created,name,email,helptopic,topic_id,subject,asset_id,status,UNIX_TIMESTAMP(closed) as closed,staff_id";
$sql.=" from isost_ticket where UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and track_id!=999999";

if($dept_id>0){
	$sql.=" and dept_id='$dept_id'";
}

if($ticket_type_id>0){
	$sql.=" and ticket_type_id='$ticket_type_id' ";
}
if($priority_id>0){
	$sql.=" and priority_id='$priority_id' ";
}

$sql.=" and status like '%$status' ";

$sql.=" order by ticket_id";
$result = mysql_query($sql);
?>

<table class="reporttable"  width=100% border="0" cellspacing=1 cellpadding=2>
		<tr>
			<td>&nbsp;</td>
			<td width=100% style='text-align: right;'><font face=Arial size=1 color=#666666><b>
			F : fault / incident&nbsp;&nbsp;
			P : problem &nbsp;&nbsp;
			S : service request&nbsp;&nbsp;
			C : change request&nbsp;&nbsp;
			</td>
		</tr>
</table>

<table class="reporttable" width=100% cellspacing=1 cellpadding=2>
<tr>	
	<td class="reportheader">ID</td>
	<td class="reportheader" width=20>Type</td>
	<td class="reportheader" width=70>Priority</td>
	<td class="reportheader" width=75>Created On</td>
	<?if ($_REQUEST["xls"]==1){?>
		<td class="reportheader">From Department</td>
		<td class="reportheader">Name</td>
		<td class="reportheader">E-Mail</td>
	<?}?>
	<td class="reportheader">Topic</td>
	<td class="reportheader">Subject</td>
	<td class="reportheader" width=70>Status</td>
	<td class="reportheader">Assigned To</td>
	<td class="reportheader" width=75>Closed</td>
	<td class="reportheader">Age<br>Hrs</td>
	</td>
</tr>

<?

while($row = mysql_fetch_row($result)){
	$ticket_id			=$row[0];
	$ticket_type_id		=$row[1];
	$priority_id		=$row[2];
	
	$created_on			=$row[3];
	$name				=$row[4];
	$email				=$row[5];
	
	$helptopic			=$row[6];
	$topic_id			=$row[7];	
	$subject			=$row[8];
	$asset_id			=$row[9];	
	$status				=$row[10];
	$closed_on			=$row[11];
	$staff_id			=$row[12];

	
	if($status=="open"){
		$closed_on="-";
	}
	
	
	$sub_sql="SELECT firstname,lastname from isost_staff where staff_id=$staff_id";
    $sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$staff_name			=$sub_row[0]." ".$sub_row[1];

	
	$type_code="F";
	if ($ticket_type_id==1){$type_code="F";}
	if ($ticket_type_id==2){$type_code="P";}
	if ($ticket_type_id==3){$type_code="C";}
	if ($ticket_type_id==4){$type_code="S";}
	
	$sub_sql="select priority_desc from isost_ticket_priority where priority_id=$priority_id";
    $sub_result = mysql_query( $sub_sql );
    $sub_row = mysql_fetch_row($sub_result);
	$priority_desc=$sub_row[0];
	
	$sub_sql="select parent_topic_id from isost_help_topic where topic_id='$topic_id'";
    $sub_result = mysql_query( $sub_sql );		
    $sub_row = mysql_fetch_row($sub_result);		
    $parent_topic_id=$sub_row[0];
	if($parent_topic_id>0){
		
			$sub_sql="select topic,parent_topic_id from isost_help_topic where topic_id='$parent_topic_id'";
			$sub_result = mysql_query( $sub_sql );
			$sub_row = mysql_fetch_row($sub_result);		

			
			$helptopic=$sub_row[0]." : ".$helptopic;
			if($sub_row[1]>0){
			
				$sub_sql="select topic from isost_help_topic where topic_id='$sub_row[1]'";
				$sub_result = mysql_query( $sub_sql );
				$sub_row = mysql_fetch_row($sub_result);	
				$helptopic=$sub_row[0]." : ".$helptopic;
			
			}

	}
	
	$sub_sql="select b.business_group from user_master a,business_groups b where a.business_group_index=b.business_group_index and (username='$email' or official_email='$email')";
    $sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$from_department=$sub_row[0];

	
	
	$sub_sql="SELECT hostname,ipaddress from asset where assetid=$asset_id";
    $sub_result = mysql_query($sub_sql);
	$sub_row=mysql_fetch_row($sub_result);
	$hostname=$sub_row[0]."-".$sub_row[1];
		
	$now=mktime();
	if($status=="closed"){
		$age	=	($closed_on-$created_on)/3600;
	}else{
		$age	=	($now-$created_on)/3600;
	}
	$age=round($age,1);
	
	
?>
	<tr>
	<td class="reportdata"><?=$ticket_id?></td>
	<td class="reportdata" style="text-align:center"><?=$type_code;?></td>
	<td class="reportdata" style="text-align:center"><?=$priority_desc?></td>
	<td class="reportdata"><?=date('d.M G:i',$created_on);?></td>
	

	<?if ($_REQUEST["xls"]==1){?>
		<td class="reportdata"><?=$from_department?></td>
		<td class="reportdata"><?=$name?></td>
		<td class="reportdata"><?=$email?></td>
	<?}?>
	<td class="reportdata"><?=$helptopic?></td>
	<td class="reportdata"><?=$subject?></td>
	<td class="reportdata"><?=$status?></td>
	<td class="reportdata"><?=$staff_name?></td>
	<td class="reportdata"><?=date('d.M G:i',$closed_on);?></td>
	<td class="reportdata"><?=$age;?></td>
	</tr>
<?
}
?>
<tr>
	<td class="reportdata"  colspan=11>
		Note : Ticket counts and listing exclude any tickets that have been merged.
	</td>
</tr>
</table>