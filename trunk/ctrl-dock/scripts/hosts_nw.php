<?
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/mail.php");
include_once("../include/mail_helper.php");
include_once("../include/ticket_post.php");


// Perform a periodic clean-up of Network Log Files
$cleanup_period=60;// 60 Days

$cleanup_period=$cleanup_period*86400;
$then=mktime()-$cleanup_period;

$sql="delete from hosts_nw_log where timestamp<$then";
$result = mysql_query($sql);

$sql="SELECT a.host_id,a.hostname,b.count,b.timeout,b.alarm_threshold,b.flap_timeout,b.flap_threshold,a.description FROM hosts_master a,hosts_nw b WHERE a.host_id=b.host_id AND a.status='1' AND b.enabled='1' ORDER BY a.hostname";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$host_id		=	$row[0];
	$hostname		=	$row[1];
	$count			=	$row[2];if($count==""){$count=4;}
	$timeout		=	$row[3];if($timeout==""){$timeout=5;}
	$alarm_threshold=	$row[4];
	$flap_timeout	=	$row[5];
	$flap_threshold	=	$row[6];
	$hostdesc		=	$row[7];
	$timestamp		=	mktime();
	
	$pingoutput=array();
	exec("ping -c $count -W $timeout -q $hostname", $pingoutput, $pingstatuscode);

	$info="";
	$min=0;
	$avg=0;
	$max=0;
	if($pingstatuscode==0){
		foreach ($pingoutput as $str){
            if (strpos($str, "min/avg/max/mdev") > 0){
                $info = $str;
                break;
            }
        }
		//$info=substr($pingoutput[4],strpos($pingoutput[4],"=")+2);
		$info = substr($info,strpos($info,"=")+2);
		$min=substr($info,0,strpos($info,"/"));		
		$info=substr($info,strpos($info,"/")+1);
		
		$avg=substr($info,0,strpos($info,"/"));
		$info=substr($info,strpos($info,"/")+1);
		$max=substr($info,0,strpos($info,"/"));
		
		$nw_status=1;
		
		//Record the entry as a flapping entry
		if($avg>=$flap_timeout){$nw_status=2;}
		
	}else{
		$nw_status=0;
	}
	
	// Log the Network Status
	$sub_sql="insert into hosts_nw_log (host_id,nw_status,min,avg,max,timestamp) values ('$host_id','$nw_status','$min','$avg','$max','$timestamp')";
	mysql_query($sub_sql);
	
	
	// If link is up, check for flapping of link
	if ($nw_status==2){
		$limit=$flap_threshold+1;
		$sub_sql="select avg,nw_status from hosts_nw_log where host_id='$host_id' order by record_id DESC LIMIT $limit";
		$sub_result = mysql_query($sub_sql);
		$flap=0;
		while ($sub_row = mysql_fetch_row($sub_result)){
			if($sub_row[0]>$flap_timeout){$flap++;}
			$last_status=$sub_row[1];
		}
		
		// If the Flap threshold is breached, then send an alert.
		if ($flap >= $flap_threshold && $last_status==1){
			$timestamp_human=date("d-M-Y H:i:s",$timestamp);
			$message  = "ALERT $hostdesc - $hostname NETWORK IS FLAPPING $timestamp_human";
			$subject=$message;
			ticket_post($smtp_email,$smtp_email,"28","$subject","$message",'1');
		}
	}
	
	
	if($nw_status==0){
		// Check the last known state of the host
		$limit=$alarm_threshold+1;
		$sub_sql	="SELECT nw_status FROM hosts_nw_log WHERE host_id='$host_id' ORDER BY record_id DESC LIMIT $limit";
		$sub_result = mysql_query($sub_sql);
		$down_count=0;		
		while($sub_row=mysql_fetch_row($sub_result)){
			if($sub_row[0]==0){$down_count++;}
			$last_status=$sub_row[0];
		}
		
		// If the host was down and breached the alarm threshold, generate a ticket
		if($down_count==$alarm_threshold && $last_status==1){			
			$timestamp_human=date("d-M-Y H:i:s",$timestamp);
			$message  = "ALERT $hostdesc - $hostname DOWN $timestamp_human";
			$subject=$message;
			ticket_post($smtp_email,$smtp_email,"28","$subject","$message",'1');
		}
	}else{
		//This section is used to send a notification mail to the respected people to say the system is UP agian
		//Check any server is UP after it went DOWN
		//$up_count_limit = $alarm_threshold; //Check the last three entries
		$limit = $alarm_threshold + 1;
		$select_up_query = sprintf("SELECT nw_status
					    FROM hosts_nw_log
					    WHERE host_id=%d
					    ORDER BY record_id DESC LIMIT %d",$host_id,$limit);
		$up_result = mysql_query($select_up_query);
		$up_count = 0;
		while($up_row = mysql_fetch_row($up_result)){
			if($up_row[0] == 1){
				$up_count++;
			}
                        $last_status=$up_row[0];
		}
		if($up_count == $alarm_threshold && $last_status == 0){
 			$timestamp_human=date("d-M-Y H:i:s",$timestamp);
			$body = "$hostdesc - $hostname UP on $timestamp_human";
			$attachement ="";
			// GET ALL THE EMAILS WHO ARE ASSOCIATED WITH THAT HOST '
			$select_email_query = sprintf("SELECT email_id
						       FROM sys_uptime_email
						       WHERE status = 'active' AND host_id = '%d'",$host_id);
			$email_result = mysql_query($select_email_query);
			while($email_row = mysql_fetch_assoc($email_result)){
				$to_email = $email_row['email_id']; 
				ezmail($to_email,$to_email,"System UP",$body,$attachement);
			}
		}
	}
}
?>
