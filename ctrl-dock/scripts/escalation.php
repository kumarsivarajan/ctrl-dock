<?
ini_set('display_errors', '0');

include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/mail.php");
include_once("../include/mail_helper.php");
include_once("../include/sms.php");
include_once("../include/system_config.php");

for($ticket_type_id=0;$ticket_type_id<=3;$ticket_type_id++){

	$sql="select ticket_type from isost_ticket_type where ticket_type_id='$ticket_type_id'";
	$result = mysql_query($sql);
	$row=mysql_fetch_row($result);
	$ticket_type=$row[0];

	$now	= mktime();

	$sql	="SELECT priority_id,UNIX_TIMESTAMP(created),subject,ticket_id,name,email,ticket_type_id FROM isost_ticket WHERE STATUS='open' and ticket_type_id='$ticket_type_id' order by ticket_id";
	$result = mysql_query($sql);

	while ($row=mysql_fetch_row($result)){
	
		// 1:low, 2: normal, 3: high, 4 : emergency, 5 : exception
		$priority	=$row[0];
		$created	=$row[1];
		$created_date=date("d M Y H:i",$row[1]);
		$subject	=$row[2];
		$ticket_id	=$row[3];
		$source_name=$row[4];
		$source_email=$row[5];
		$ticket_type_id=$row[6];
		
		if($ticket_type_id==1){$type_prefix="I";}
		if($ticket_type_id==3){$type_prefix="C";}
		if($ticket_type_id==4){$type_prefix="S";}
		
	
		// Get Last assigned information
		$sub_sql="select firstname,lastname,username from isost_staff a,isost_ticket b where a.staff_id=b.staff_id and b.ticket_id='$ticket_id'";
		$sub_result = mysql_query($sub_sql);		
		$sub_row=mysql_fetch_row($sub_result);		
		$last_assigned_to		=$sub_row[0]." ".$sub_row[1];
		$last_assigned_user		=$sub_row[2];
	

		if($priority==1){$priority="low";$priority_desc="LOW";}
		if($priority==2){$priority="medium";$priority_desc="NORMAL";}
		if($priority==3){$priority="high";$priority_desc="HIGH";}
		if($priority==4){$priority="emergency";$priority_desc="EMRG";}
		if($priority==5){$priority="exception";$priority_desc="EXCP";}

		echo "\nProcessing Ticket #$ticket_id : $priority : $subject\n";

	
		if($priority=="emergency"){
			$sub_sql	="select count(*) from escalations_log where ticket_id='$ticket_id'";
			$sub_result = mysql_query($sub_sql);
			$sub_row	= mysql_fetch_row($sub_result);
					
			$count		= $sub_row[0];
				
			if ($count==0){
		
				$esc_subject="# $ticket_id : $type_prefix $priority_desc : $subject";
				$esc_body="You are recieving this email, because an emergency ticket has been logged which requires all members of the escalation matrix be notified immediately.\n\n";
				$esc_body.="Logged By : $source_name ($source_email)\n\n";
				$esc_body.="Ticket Type : $ticket_type\n\n";

				$esc_sql="SELECT a.esc_id,b.official_email,contact_phone_mobile,b.username,b.first_name,b.last_name FROM escalations a,user_master b WHERE a.esc_username=b.username and a.ticket_type_id='$ticket_type_id' order by a.esc_id";
				$esc_result = mysql_query($esc_sql);				
				while ($esc_row	= mysql_fetch_row($esc_result)){
					$level		=$esc_row[0];
					$email		=$esc_row[1];
					$phone		=$esc_row[2];
					$username	=$esc_row[3];
					$full_name	=$esc_row[4]." ".$esc_row[5];				
				
					if(strlen($username)>0){
						$sub_sql="insert into escalations_log (ticket_id,level,esc_username,timestamp) values ('$ticket_id','$level','$username','$now')";
						$sub_result = mysql_query($sub_sql);
							
						// Generate an email						
						ezmail("$email","$full_name","$esc_subject","$esc_body","");
						
						// Update RIM Master Escalation
						if($ezRIM==1){
							if($ticket_type_id==1){$ticket_type="Incident";}
							if($ticket_type_id==3){$ticket_type="Change Request";}
							if($ticket_type_id==4){$ticket_type="Service Request";}
							rim_master_update ($ticket_id,$created,$subject,$ticket_type,$priority_desc,$last_assigned_user,$level);
						}
					}
					
					// Generate an SMS
					if (strlen($phone)>0){
							$phone = str_replace(' ','',$phone);						
							ezsms("$phone","$esc_body");						
							sleep(2);
					}
				}			
			}
		}else{

			$sub_sql_1	="SELECT a.esc_id,b.official_email,contact_phone_mobile,$priority,b.username,b.first_name,b.last_name FROM escalations a,user_master b WHERE a.esc_username=b.username and a.ticket_type_id='$ticket_type_id' order by a.esc_id";
			$sub_result_1 = mysql_query($sub_sql_1);
		
			while ($sub_row_1=mysql_fetch_row($sub_result_1)){
			
				$level		=$sub_row_1[0];
				$email		=$sub_row_1[1];
				$phone		=$sub_row_1[2];
				$threshold	=$sub_row_1[3]*3600;//Convert to seconds
				$username	=$sub_row_1[4];
				$full_name	=$sub_row_1[5]." ".$sub_row_1[6];
				$diff		=($now - $created);
			
				
				if($diff>=$threshold){
					
					$esc_subject="Escalation $level : # $ticket_id : $type_prefix $priority_desc : $subject";				
					$esc_body="";
					
					// Check if an escalation has already been sent for this ticket
					$sub_sql_2	="select count(*) from escalations_log where ticket_id='$ticket_id' and level='$level'";
					$sub_result_2 = mysql_query($sub_sql_2);
					$sub_row_2	= mysql_fetch_row($sub_result_2);
					$count		= $sub_row_2[0];
					
					if ($count==0){
						echo "Escalation $level is pending, being initiated now\n";
						
						$esc_body="You are recieving this email, because a ticket raised by \n";
						$esc_body.="$source_name ($source_email) at $created_date\n";
						$esc_body.="has not been closed in the stipulated time.\n\n";
						
						if(strlen($first_review_by)>0){
							$esc_body.="The ticket was last assigned to $last_assigned_to \n\n";
						}
						
						if($level==1){$esc_body.="This is the first escalation for this ticket.\n\n";}
						if($level>1) {$esc_body.="This ticket has been escalated as per the following history.\n\n";}
											
						$sub_sql_3="select b.first_name,b.last_name,a.timestamp,a.level from escalations_log a,user_master b where a.esc_username=b.username and ticket_id='$ticket_id' order by a.level";
						$sub_result_3 = mysql_query($sub_sql_3);
						$prev_esc	="";
						while ($sub_row_3=mysql_fetch_row($sub_result_3)){
							$prev_esc_user		=$sub_row_3[0]." ".$sub_row_3[1];
							$prev_esc_time_stamp	=date("d M Y H:i",$sub_row_3[2]);
							$prev_level		=$sub_row_3[3];
							$prev_esc		.="Escalation Level : ".$prev_level." ".$prev_esc_user." ".$prev_esc_time_stamp;						
							$prev_esc		.="\n\n";
						}
						$esc_body.=$prev_esc;
						$esc_body.="\nYou are requested to act on this notification to avoid further breach of SLA";

						$sub_sql_4="insert into escalations_log (ticket_id,level,esc_username,timestamp) values ('$ticket_id','$level','$username','$now')";
						$sub_result_4 = mysql_query($sub_sql_4);
					
						// Generate an email						
							ezmail("$email","$full_name","$esc_subject","$esc_body","");	
							
						// Update RIM Master Escalation
						if($ezRIM==1){
							if($ticket_type_id==1){$ticket_type="Incident";}
							if($ticket_type_id==3){$ticket_type="Change Request";}
							if($ticket_type_id==4){$ticket_type="Service Request";}
							rim_master_update ($ticket_id,$created,$subject,$ticket_type,$priority_desc,$last_assigned_user,$level);
						}
						
						// Update Ticket Over Due status
						if($level==3){
							$sub_sql_5="update isost_ticket set isoverdue=1 where ticket_id='$ticket_id'";
							$sub_result_5 = mysql_query($sub_sql_5);
						}
						
						// Generate an SMS
						if (strlen($phone)>0){
							$phone = str_replace(' ','',$phone);						
							ezsms("$phone","$message");						
							sleep(2);
						}
					}
				}
			}
		}
	}
}

function rim_master_update ($ticket_id,$ticket_date,$ticket_summary,$ticket_type,$ticket_priority,$assigned_to,$escalation_level){
	global $MASTER_URL,$MASTER_API_KEY,$AGENCY_ID;
	// Update RIM Master
	$url=$MASTER_URL."/api/rim_master_escalation.php";			
	
	$fields = array(
		'key'=>urlencode($MASTER_API_KEY),		
		'agency'=>urlencode($AGENCY_ID),
		'ticket_id'=>urlencode($ticket_id),
		'ticket_date'=>urlencode($ticket_date),
		'ticket_summary'=>urlencode($ticket_summary),
		'ticket_type'=>urlencode($ticket_type),
		'ticket_priority'=>urlencode($ticket_priority),
		'assigned_to'=>urlencode($assigned_to),
		'escalation_level'=>urlencode($escalation_level)
	);
	
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
				
	$ch = curl_init();	
			
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_TIMEOUT,60);		
	curl_setopt($ch, CURLOPT_POST,count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	$data = curl_exec($ch);	
			
	curl_close($ch);
}
?>
