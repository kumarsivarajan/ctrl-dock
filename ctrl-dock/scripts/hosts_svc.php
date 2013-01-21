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

$sql="delete from hosts_service_log where timestamp<$then";
$result = mysql_query($sql);



$sql="SELECT a.host_id,a.hostname,b.port,b.alarm_threshold FROM hosts_master a,hosts_service b WHERE a.host_id=b.host_id AND a.status='1' AND b.enabled='1' ORDER BY a.hostname";
$result = mysql_query($sql);

while ($row = mysql_fetch_row($result)){
	$host_id		=	$row[0];
	$hostname		=	$row[1];
	$port			=	$row[2];
	$alarm_threshold=	$row[3];
	$timestamp		=	mktime();
	
	$sub_sql	="SELECT description FROM hosts_service WHERE host_id='$host_id' and port='$port'";
	$sub_result = mysql_query($sub_sql);
	$sub_row	= mysql_fetch_row($sub_result);
	$svc		= $sub_row[0];

	
	$connection=@fsockopen($hostname,$port,$errno, $errstr,3);
		
	if ($connection) {
		$svc_status=1;
		fclose($connection);
	}else{
		$svc_status=0;
	}
	
	$sub_sql="insert into hosts_service_log (host_id,port,svc_status,timestamp) values ('$host_id','$port','$svc_status','$timestamp')";
	$sub_result = mysql_query($sub_sql);
	
	if ($svc_status==0){
		// Check the last known state of the host and the service
		$limit=$alarm_threshold+1;
		$sub_sql	="SELECT svc_status FROM hosts_service_log WHERE host_id='$host_id' and port='$port' ORDER BY record_id DESC LIMIT $limit";
		$sub_result = mysql_query($sub_sql);
		$down_count=0;		
		while($sub_row=mysql_fetch_row($sub_result)){
			if($sub_row[0]==0){$down_count++;}
			$last_status=$sub_row[0];
		}
		
		// If the service was down and breached the alarm threshold, generate a ticket
		if($down_count==$alarm_threshold && $last_status==1){	
			$timestamp_human=date("d-M-Y H:i:s",$timestamp);
			$message  = "ALERT $hostname $svc($port) DOWN $timestamp_human";
			$subject=$message;
			ticket_post($smtp_email,$smtp_email,"28","$subject","$message",'1');		
		}
	}
	
}