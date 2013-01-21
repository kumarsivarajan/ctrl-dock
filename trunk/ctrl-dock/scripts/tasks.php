<?
include_once("../include/config.php");
include_once("../include/db.php");

include_once("../include/mail.php");
include_once("../include/mail_helper.php");
include_once("../include/ticket_post.php");

$currtimestamp=mktime();
$curday=date('D',$currtimestamp); // Sun,Mon,Tue etc.

$sql="select * from scheduled_tasks";

$result=mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$scheduledate		=$row['scheduled_date'];
	$scheduledayearlier	=$row['scheduled_day'];
	$schedulehr			=$row['scheduled_hr'];
	$schedulemm			=$row['scheduled_min'];
	$taskid				=$row['task_id'];
	$task_summary		=$row['task_summary'];
	$task_description	=$row['task_description'];	
	$recurtype			=$row['recurchoice'];
	$recurvalue			=$row['recur'];
	
	$scheduleday		=date('D',$scheduledate);
	if ($recurtype == "day"){
		$factor=1;
	}elseif ($recurtype == "week"){
		$factor=7;
	}
	$taskposted			=$row['task_posted'];	
	
	$nextschedule_month = date('m',$scheduledate);
	$nextschedule_date = date('d',$scheduledate);
	$nextschedule_year = date('Y',$scheduledate);
	$correctedschedule_date = mktime($schedulehr, $schedulemm, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
	if($scheduledayearlier != NULL){		
		$upgradescheduleday = date('D',$scheduledate);
		if($scheduledayearlier == $upgradescheduleday){			
			$nextscheduledate = $correctedschedule_date;
		}else{ //Go back to that "Schedule Day"
			$lastdate = date('d', strtotime("last $scheduledayearlier"));
			$lastmonth = date('m', strtotime("last $scheduledayearlier"));
			$lastyear = date('Y', strtotime("last $scheduledayearlier"));
			$nextscheduledate = mktime($schedulehr, $schedulemm, 00, $lastmonth, $lastdate, $lastyear);
			echo "Next Schedule Date1 is $nextscheduledate\n";
			while($nextscheduledate < $currtimestamp){
				$nextschedule= $recurvalue * $factor;
				$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$nextscheduledate));
				$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$nextscheduledate));
				$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$nextscheduledate));
				$nextscheduledate = mktime($schedulehr, $schedulemm, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
				if ($recurvalue == 0){
					break;
				}
			}			
		}
		
		$sql = mysql_query("update scheduled_tasks set task_posted='$nextscheduledate',scheduled_day=NULL, scheduled_date='$correctedschedule_date' where task_id='$taskid'");
		$taskposted = $nextscheduledate;
	}
	
	if($taskposted != NULL || $taskposted !=0){
		$taskscheduleday	=date('D',$taskposted);
	}
	
	if($taskposted != NULL){
		if($recurvalue > 0){
			if($recurtype == "day" || $recurtype == "week"){
				$nextschedule= $recurvalue*$factor;
				$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$taskposted));
				$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$taskposted));
				$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$taskposted));
				$nextscheduledate = mktime($schedulehr, $schedulemm, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
				while($nextscheduledate < $currtimestamp){
					$nextschedule_month = date('m',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_date = date('d',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextschedule_year = date('Y',strtotime('+'.$nextschedule.' days',$nextscheduledate));
					$nextscheduledate = mktime($schedulehr, $schedulemm, 00, $nextschedule_month, $nextschedule_date, $nextschedule_year);
				}
			}
			elseif($recurtype == "date"){
				$nextscheduledate = strtotime('+'.$recurvalue. 'month',$taskposted);
				while($nextscheduledate < $currtimestamp)
					{
					$nextscheduledate = strtotime('+'.$recurvalue. 'month',$nextscheduledate);
					}
			}
			else{
				$monthval = date('n',$taskposted);
				$nextschedule= $recurvalue + $monthval;
				if($nextschedule > 12){
					$nextschedule = $nextschedule % 12;
					if($nextschedule == 0){
						$nextschedule=12;
					}
				}
				
				$nextmonthfirstdaytimestamp = mktime($schedulehr,$schedulemm,00,$nextschedule,1,date('Y',$taskposted));
				$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
				$currmonth= date('m',$nextmonthfirstdaytimestamp);
				$curryear = date('Y',$nextmonthfirstdaytimestamp);

				$nextscheduledate = mktime($schedulehr,$schedulemm,00,$currmonth,$lastdate,$curryear);
				while($nextscheduledate < $currtimestamp){
					$nextschedule= $recurvalue + $nextschedule;
					$nextmonthfirstdaytimestamp = mktime($schedulehr,$schedulemm,00,$nextschedule,1,date('Y',$nextscheduledate));
					$lastdate = date('t',$nextmonthfirstdaytimestamp); // next month no. of days
					$currmonth= date('m',$nextmonthfirstdaytimestamp);
					$curryear = date('Y',$nextmonthfirstdaytimestamp);

					$nextscheduledate = mktime($schedulehr,$schedulemm,00,$currmonth,$lastdate,$curryear);
				}
			}
		}elseif($recurvalue == 0){
			$returndate = date('d', strtotime("next $taskscheduleday"));
			$returnmonth = date('m', strtotime("next $taskscheduleday"));
			$returnyear = date('Y', strtotime("next $taskscheduleday"));
			$returnvalue1 = mktime($schedulehr, $schedulemm, 00, $returnmonth, $returndate, $returnyear);
			$nextscheduledate = $returnvalue1;
			$sql = mysql_query("update scheduled_tasks set task_posted='$nextscheduledate' where task_id='$taskid'");
		}
	}
	
	$diffscheduletime = $taskposted - $currtimestamp;
	
	if($taskscheduleday == $curday && $recurvalue >= 0 ){
		if($diffscheduletime <= 3600 && $diffscheduletime > 0){
			$subject	= $task_summary;
			$message  	= "SCHEDULED ACTIVITY : ".$task_description;
	
			ticket_post($smtp_email,$smtp_email,"29","$subject","$message",'4');
			
			if($recurvalue == 0){
				$sql = mysql_query("update scheduled_tasks set recur=-1,task_posted=0 where task_id='$taskid'");
			}else{
				$sql = mysql_query("update scheduled_tasks set task_posted='$nextscheduledate' where task_id='$taskid'");
			}
		}elseif($diffscheduletime < 0){
			$sql = mysql_query("update scheduled_tasks set task_posted='$nextscheduledate' where task_id='$taskid'");
		}
	}
}