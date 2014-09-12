<?php
if ($_REQUEST["xls"]==1){
	$timestamp=date('d-m-Y-H-i-s',mktime());
	$filename="ESCALATION_SUMMARY_".$timestamp.".xls";
	
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=$filename"); 
}

include_once("config.php");
$tkt_count=0;

?>

<center>
<br>
<table border="0" cellpadding="0" cellspacing="0" width=100%>
<tr>
	<?if($_REQUEST["xls"]!=1){?>
	<td class=reportdata style="text-align:right" width=100><a target=_new href='escalations.php?xls=1'><b>Export to Excel</a></td>
	<?}?>
</tr>
</table>
<br>

<?
$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created) as created,name,email,helptopic,topic_id,subject,staff_id,close_tkt_location";
$sql.=" from isost_ticket where track_id!=999999 and status='open'";
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
			&nbsp;&nbsp;&nbsp;&nbsp;
			OS : on-site&nbsp;&nbsp;
			R : remote&nbsp;&nbsp;
			
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
	<td class="reportheader">Assigned To</td>
	</td>
</tr>
<tr><td class=reportdata bgcolor=#FF0000 colspan=10><b>Escalation Level 3 - SLA Breach</b></tr>

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
	$staff_id			=$row[9];
	$closed_location	=$row[10];
	if ($closed_location=="remotely"){$closed_location="R";}
	if ($closed_location=="locally"){$closed_location="OS";}
	
	$sub_sql="select level from escalations_log where ticket_id='$ticket_id'";
	$sub_result = mysql_query($sub_sql);
	$esc_count=mysql_num_rows($sub_result);
	
	if ($esc_count==3){
	$tkt_count++;
	
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
		
	
?>
	<tr>
	<td class="reportdata"><a href=../eztickets/scp/tickets.php?id=<?=$ticket_id?> target=_new><?=$ticket_id?></a></td>
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
	<td class="reportdata"><?=$staff_name?></td>
	</tr>
<?
	}
}
?>
<tr><td class=reportdata colspan=10><b>No. of Escalations : <?=$tkt_count;?></b></tr>
<tr><td class=reportdata bgcolor=#FF6A00 colspan=10><b>Escalation Level 2</b></tr>


<?
$tkt_count=0;
///// Escalation - 2
$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created) as created,name,email,helptopic,topic_id,subject,staff_id,close_tkt_location";
$sql.=" from isost_ticket where track_id!=999999 and status='open'";
$sql.=" order by ticket_id";
$result = mysql_query($sql);

?>



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
	$staff_id			=$row[9];
	$closed_location	=$row[10];
	if ($closed_location=="remotely"){$closed_location="R";}
	if ($closed_location=="locally"){$closed_location="OS";}
	
	$sub_sql="select level from escalations_log where ticket_id='$ticket_id'";
	$sub_result = mysql_query($sub_sql);
	$esc_count=mysql_num_rows($sub_result);
	
	if ($esc_count==2){
	$tkt_count++;

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
		
	
?>
	<tr>
	<td class="reportdata"><a href=../eztickets/scp/tickets.php?id=<?=$ticket_id?> target=_new><?=$ticket_id?></a></td>
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
	<td class="reportdata"><?=$staff_name?></td>
	</tr>
<?
	}
}
?>
<tr><td class=reportdata colspan=10><b>No. of Escalations : <?=$tkt_count;?></b></tr>
<tr><td class=reportdata bgcolor=#FFD800 colspan=10><b>Escalation Level 1</b></tr>

<?
$tkt_count=0;
///// Escalation - 1
$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created) as created,name,email,helptopic,topic_id,subject,staff_id,close_tkt_location";
$sql.=" from isost_ticket where track_id!=999999 and status='open'";
$sql.=" order by ticket_id";
$result = mysql_query($sql);

?>



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
	$staff_id			=$row[9];
	$closed_location	=$row[10];
	if ($closed_location=="remotely"){$closed_location="R";}
	if ($closed_location=="locally"){$closed_location="OS";}
	
	$sub_sql="select level from escalations_log where ticket_id='$ticket_id'";
	$sub_result = mysql_query($sub_sql);
	$esc_count=mysql_num_rows($sub_result);
	
	if ($esc_count==1){
	$tkt_count++;

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
		
	
?>
	<tr>
	<td class="reportdata"><a href=../eztickets/scp/tickets.php?id=<?=$ticket_id?> target=_new><?=$ticket_id?></a></td>
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
	<td class="reportdata"><?=$staff_name?></td>
	</tr>
<?
	}
}

?>
<tr><td class=reportdata colspan=10><b>No. of Escalations : <?=$tkt_count;?></b></tr>


<tr>
	<td class="reportdata"  colspan=11>
		Note : Ticket counts and listing exclude any tickets that have been merged.
	</td>
</tr>
</table>