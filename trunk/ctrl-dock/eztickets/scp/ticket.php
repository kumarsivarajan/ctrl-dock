<?
$sub_sql="select b.ticket_type,a.priority_id,a.ticket_type_id,a.topic_id,a.helptopic,a.pending_approval,a.status,a.asset_id,a.subject";
$sub_sql.=" from isost_ticket a,isost_ticket_type b where a.ticket_type_id=b.ticket_type_id and a.ticket_id=$ticket_id";

$sub_result = mysql_query( $sub_sql );
$sub_row = mysql_fetch_row($sub_result);		

$ticket_type=$sub_row[0];
$priority_id=$sub_row[1];
$ticket_type_id=$sub_row[2];
$topic_id=$sub_row[3];
$helptopic=$sub_row[4];
$pending_approval=$sub_row[5];
$ticket_status=$sub_row[6];
$assetid=$sub_row[7];
$subject=$sub_row[8];
if($pending_approval==1){$pending_approval="Pending Approval";}else{$pending_approval="";}
		
		
if($ticket_type_id==1){$type_prefix="C";}
if($ticket_type_id==2){$type_prefix="S";}
if($ticket_type_id==3){$type_prefix="P";}


$sub_sql="select priority_desc,priority_color from isost_ticket_priority where priority_id=$priority_id";
$sub_result = mysql_query( $sub_sql );
$sub_row = mysql_fetch_row($sub_result);
$priority_desc=$sub_row[0];
$priority_color=$sub_row[1];

		
		
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

		
$sql="SELECT hostname,ipaddress from asset where assetid=$assetid";
$result = mysql_query($sql);
$row=mysql_fetch_row($result);
$hostname=$row[0]."-".$row[1];
?>
	<table border=1 width=1000 cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5">
			<tr>
				<td class=reportheader colspan=2 style='text-align:left'><b>TICKET ID # <?=$ticket_id;?></b></td>				
			</tr>
	
			<tr>
				<td class=reportdata><b>Status</b></td>
				<td class=reportdata style='background-color:#CFCFCF'><b><?=strtoupper($ticket_status)?> <?=$pending_approval?></b></td>
			</tr>

			<tr>
				<td class=reportdata><b>Type</b></td>
				<td class=reportdata><?=$ticket_type;?></td>
			</tr>
			<tr>
        		<td class=reportdata><b>Priority</b></td>
                <td class=reportdata style='background-color:<?=$priority_color?>'><?=$type_prefix?> <?=$priority_desc?></td>
   	 		</tr>
            <tr>
				<td class=reportdata><b>Category</b></td>
                <td class=reportdata><?=$helptopic?></td>      
			</tr>
            <tr>
			<tr>
				<td class=reportdata><b>Hostname</b></td>
				<td class=reportdata><b><?=$hostname?><b></td>
			</tr>
			<tr>
				<td class=reportdata><b>Subject</b></td>
				<td class=reportdata><b><?=$subject?><b></td>
			</tr>
		</table>
		<br>
	<?
	    //get messages
        $sql='SELECT msg.created,msg.message,msg.msg_id as attachments  FROM isost_ticket_message msg '.
            ' LEFT JOIN isost_ticket_attachment'." attach ON  msg.ticket_id=attach.ticket_id AND msg.msg_id=attach.ref_id AND ref_type='M' ".
            ' WHERE  msg.ticket_id='.$ticket_id.
            ' GROUP BY msg.msg_id ORDER BY created'; 
		
		$result = mysql_query($sql);

	    while ($row=mysql_fetch_row($result)) {
			$msg_created=$row[0];
			$msg=$row[1];
			$msg_id=$row[2];
		    ?>
		    <table border=1 width=1000 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#CCCCFF>
		        <tr><td bgcolor=#DSDFF3><font face=Arial size=2 color=black><?=$msg_created?></td></tr>
                <tr><td bgcolor=#FFFFFF><font face=Arial size=2 color=black><br><?=nl2br($msg)?><br></td></tr>
		    </table>
			<br>
            <?
            //get answers for messages
			
            $sub_sql='SELECT resp.created,resp.staff_name,resp.response as attachments FROM isost_ticket_response resp '.
                ' LEFT JOIN isost_ticket_attachment'." attach ON  resp.ticket_id=attach.ticket_id AND resp.response_id=attach.ref_id AND ref_type='R' ".
                ' WHERE msg_id='.$msg_id .' AND resp.ticket_id='.$ticket_id.
                ' GROUP BY resp.response_id ORDER BY created';
			$sub_result = mysql_query($sub_sql);

			while ($sub_row=mysql_fetch_row($sub_result)) {
                $response_created=$sub_row[0];
				$response_staff=$sub_row[1];
				$response=$sub_row[2];
				
                ?>
				<table border=1 width=1000 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#CCCCFF>
					<tr><td bgcolor=#FFE0B3><font face=Arial size=2 color=black><?=$response_created?> - <?=$response_staff?></td></tr>
					<tr><td bgcolor=#FFFFFF><font face=Arial size=2 color=black><br><?=nl2br($response)?><br></td></tr>
				</table>
				<br>
	        <?}
	    }?>