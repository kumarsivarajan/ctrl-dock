<?
ini_set('display_errors', '0');

include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/mail.php");
include_once("../include/mail_helper.php");
include_once("../include/sms.php");
include_once("../include/system_config.php");

// Check the open tickets and set due dates as per the escalation matrix
$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created) from isost_ticket where track_id!='999999' and status='open' and duedate is NULL order by ticket_id";
$result = mysql_query($sql);
while ($row=mysql_fetch_row($result)){
	$ticket_id		=$row[0];
	$ticket_type_id	=$row[1];
	$priority_id	=$row[2];	// 1:low, 2: normal, 3: high, 4 : emergency, 5 : exception
	$created_date	=$row[3];
	
	if($priority_id==1){$priority="low";$priority_desc="LOW";}
	if($priority_id==2){$priority="medium";$priority_desc="NORMAL";}
	if($priority_id==3){$priority="high";$priority_desc="HIGH";}
	if($priority_id==4){$priority="emergency";$priority_desc="EMRG";}
	if($priority_id==5){$priority="exception";$priority_desc="EXCP";}
	
	
	$sub_sql="select $priority from escalations where esc_id=1 and ticket_type_id='$ticket_type_id'";
	$sub_result = mysql_query($sub_sql);
	$sub_row	= mysql_fetch_row($sub_result);
	$hours		= $sub_row[0];
	
	$due_date=$created_date+($hours*3600);
	
	$sub_sql="update isost_ticket set duedate=FROM_UNIXTIME('$due_date') where ticket_id='$ticket_id'";
	//$sub_result = mysql_query($sub_sql);
}

// Get current date & time
$now	= time();

$sql="select ticket_id,ticket_type_id,priority_id,UNIX_TIMESTAMP(created),UNIX_TIMESTAMP(duedate),subject,name,email from isost_ticket where track_id!='999999' and status='open' and priority_id<5 order by ticket_id ";
$result = mysql_query($sql);
while ($row=mysql_fetch_row($result)){

	$ticket_id		=$row[0];
	$ticket_type_id	=$row[1];
	$priority_id	=$row[2];	// 1:low, 2: normal, 3: high, 4 : emergency, 5 : exception
	$created_date	=$row[3];$created_date_print=date("d M Y H:i",$row[3]);
	$due_date		=$row[4];$due_date_print=date("d M Y H:i",$row[4]);
	$subject		=$row[5];
	$source_name	=$row[6];
	$source_email	=$row[7];

	echo "Processing ticket $ticket_id created on $created_date_print (Type ID : $ticket_type_id Priority ID : $priority_id) Due Date : $due_date_print \n";
	
	// Get Last assigned information
	$sub_sql="select firstname,lastname,username from isost_staff a,isost_ticket b where a.staff_id=b.staff_id and b.ticket_id='$ticket_id'";
	$sub_result = mysql_query($sub_sql);		
	$sub_row=mysql_fetch_row($sub_result);		
	$last_assigned_to		=$sub_row[0]." ".$sub_row[1];
	$last_assigned_user		=$sub_row[2];
	
	// Get Ticket Message
	$sub_sql="select message from isost_ticket_message where ticket_id='$ticket_id'";
	$sub_result = mysql_query($sub_sql);		
	$sub_row=mysql_fetch_row($sub_result);		
	$ticket_message	=$sub_row[0];
	
	if($ticket_type_id==1){$type_prefix="I";$ticket_type="Incident";}
	if($ticket_type_id==3){$type_prefix="C";$ticket_type="Change Request";}
	if($ticket_type_id==4){$type_prefix="S";$ticket_type="Service Request";}
	
	
	if($priority_id==1){$priority="low";$priority_desc="LOW";}
	if($priority_id==2){$priority="medium";$priority_desc="NORMAL";}
	if($priority_id==3){$priority="high";$priority_desc="HIGH";}
	if($priority_id==4){$priority="emergency";$priority_desc="EMRG";}
	if($priority_id==5){$priority="exception";$priority_desc="EXCP";}

	
	if ($now > $due_date){
		
		$sub_sql="select * from escalations_log where ticket_id='$ticket_id'";
		$sub_result = mysql_query($sub_sql);
		$escalation_count	= mysql_num_rows($sub_result);
		
		if ($escalation_count>0 && $escalation_count<3){
			$sub_sql="select max(level) from escalations_log where ticket_id='$ticket_id'";
			$sub_result = mysql_query($sub_sql);
			$sub_row	= mysql_fetch_row($sub_result);
			$escalation_count	= $sub_row[0];
		}
		
		$escalation_level=$escalation_count+1;
		
		
		if ($escalation_level<=3){
		
			// get information from escalation matrix
			if($escalation_level==1){$get_level=2;}
			if($escalation_level==2){$get_level=3;}
			
			if($escalation_level==1 || $escalation_level==2){
			
				$sub_sql="select $priority from escalations where esc_id=$get_level and ticket_type_id='$ticket_type_id'";
				$sub_result = mysql_query($sub_sql);
				$sub_row	= mysql_fetch_row($sub_result);
				$hours		= $sub_row[0];
			
				$due_date=$created_date+($hours*3600);$due_date_print=date("d M Y H:i",$due_date);
				
				echo "Updating new date to $due_date_print\n\n";
				// Update the Due Date
				$sub_sql="update isost_ticket set duedate=FROM_UNIXTIME('$due_date'),isoverdue=1 where ticket_id='$ticket_id'";
				$sub_result = mysql_query($sub_sql);
			}
		
		
			// Update Escalation Log
			$sub_sql="insert into escalations_log (ticket_id,level,timestamp) values ('$ticket_id','$escalation_level','$now')";
			$sub_result = mysql_query($sub_sql);
			
			// Update RIM Master Escalation
			if($ezRIM==1){
				rim_master_update ($ticket_id,$created_date,$subject,$ticket_type,$priority_desc,$last_assigned_user,$escalation_level);
			}
		
			// Prepare to send email
			$esc_subject="Escalation Level : $escalation_level : # $ticket_id : $priority_desc : $subject";
			$esc_body="You are receiving this email, because a ticket has not been closed in the stipulated time\n\n";
			$esc_body.="Logged By : $source_name ($source_email)\n\n";
			$esc_body.="Logged On : $created_date_print\n\n";
			$esc_body.="Ticket Type : $ticket_type\n\n";
			$esc_body.="Ticket Priority : $priority_desc\n\n";
			$esc_body.="Ticket Message : \n\n";
			$esc_body.=$ticket_message;

			
			// Send EMail			
			$sub_sql	= "select * from escalation_email";
			$sub_result = mysql_query($sub_sql);
			$sub_row 	= mysql_fetch_row($sub_result);
			$email	= $sub_row[0];
			ezmail("$email","$email","$esc_subject","$esc_body","");
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
