<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";



// This API is used to count the number of tickets based on helptopic
// ticket_count_by_helptopics.php?key=abcd&status=open
// Possible Values are 
// status = open,closed,all
// start_date 	= start of the date range in unix timestamp
// end_date 	= end of the date range in unix timestamp


function invalid(){
	echo "<node>";
		echo "<count>invalid</count>";
	echo "</node>";
	die(0);
}

function success($count){
	echo "<node>";
		echo "<count>".$count."</count>";
	echo "</node>";
	die(0);
}

function showxml($result, $num_rows){
global $status,$start_date,$end_date;


if($num_rows>0){
			echo "<node>";
			while($row = mysql_fetch_array($result)){
				$topic_id=$row['topic_id'];
				$topic=$row['topic'];
				
				$sub_result = mysql_query("SELECT * from isost_ticket where topic_id='$topic_id' and status like '$status' and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date");
				$sub_row = mysql_fetch_array($sub_result);
				$count = mysql_num_rows($sub_result);
				
				// Fetch the recordset to calculate average closure time
				$sub_sql="SELECT ticket_id,UNIX_TIMESTAMP(created),UNIX_TIMESTAMP(closed) from isost_ticket where topic_id='$topic_id' and status like '$status'  and track_id!=999999 and closed IS NOT NULL and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";
				$sub_result = mysql_query($sub_sql);
				$record_count=mysql_num_rows($sub_result);
				
				$total_close_time	=0;
				$total_response_time=0;
					
				while ($sub_row = mysql_fetch_row($sub_result)){
					$ticket_id		=$sub_row[0];
					$created		=$sub_row[1];
					$closed			=$sub_row[2];	
				
					$close_time			=($closed-$created)/3600;
					$total_close_time	=$total_close_time + $close_time;
					
					// Fetch information for Response Time
					
					$sub_sql_1		="SELECT UNIX_TIMESTAMP(created) from isost_ticket_response where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created) > $created  order by response_id LIMIT 1";
					$sub_result_1 	= mysql_query($sub_sql_1);
					
					if(mysql_num_rows($sub_result_1)>0){
						$sub_row_1 = mysql_fetch_row($sub_result_1);
						$first_response	=$sub_row_1[0];
									
						$response_time=($first_response-$created)/3600;
						$total_response_time	=$total_response_time + $response_time;
					}
					
				}
								
				// Compute Average Closure Time
				$avg_closure=round($total_close_time/$record_count,1);
								
				// Compute Average Response Time
				$avg_response=round($total_response_time/$record_count,1);	
				
				// Open tickets
				$open_ticket_sql="SELECT count(topic_id) FROM isost_ticket where topic_id='$topic_id' and status='open' and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";				
				$open_ticket_result = mysql_query($open_ticket_sql);			
				$open_ticket='';
				while($sub_row = mysql_fetch_array($open_ticket_result)){				
					$open_ticket = $sub_row[0];
				}
				
				// SLA Breached
				$sla_sql="SELECT count(isoverdue) FROM isost_ticket where topic_id='$topic_id' and isoverdue=1 and status='open'  and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";				
				$sla_result = mysql_query($sla_sql);				
				$sla_breached='';
				while($sub_row = mysql_fetch_array($sla_result)){		
					$sla_breached= $sub_row[0];
				}
				
				// Fetch the recordset to calculate total time spent
				$sub_sql="SELECT ticket_id from isost_ticket where topic_id='$topic_id' and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";
				$sub_result = mysql_query($sub_sql);
				$time_spent			=0;
				
				while ($sub_row = mysql_fetch_row($sub_result)){
					$ticket_id		=$sub_row[0];
				
					// Get Total Time Spent on Responses
					$ts_sql		="select SUM(time_spent) from isost_ticket_response where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
					$ts_result  = mysql_query($ts_sql);
					$ts_row 	= mysql_fetch_row($ts_result);
					$time_spent	= $time_spent + round($ts_row[0],1);
					
					// Get Total Time Spent on Internal Notes
					$ts_sql		="select SUM(time_spent) from isost_ticket_note where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
					$ts_result  = mysql_query($ts_sql);
					$ts_row 	= mysql_fetch_row($ts_result);
					$time_spent	= $time_spent + round($ts_row[0],1);
				}

				echo "<helptopic>";
					echo "<topic><![CDATA[".$topic."]]></topic>";				
					echo "<topic_id>".$topic_id."</topic_id>";
					echo "<count>".$count."</count>";
					echo "<avg_response>".$avg_response."</avg_response>";
					echo "<avg_closure>".$avg_closure."</avg_closure>";
					echo "<open_ticket>".$open_ticket."</open_ticket>"; 
					echo "<sla_breached>".$sla_breached."</sla_breached>";
					echo "<time_spent>".$time_spent."</time_spent>";
				echo "</helptopic>";
			}
			
			// Fetch the count for uncategorized tickets
			$sub_result = mysql_query("SELECT * from isost_ticket where topic_id='0' and status like '$status'  and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date");
			$sub_row = mysql_fetch_array($sub_result);
			$count = mysql_num_rows($sub_result);
			
			$open_ticket_sql="SELECT count(topic_id) FROM isost_ticket where topic_id='0' and status='open'  and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";				
				$open_ticket_result = mysql_query($open_ticket_sql);				
				$open_ticket='';
				while($sub_row = mysql_fetch_array($open_ticket_result)){				
					$open_ticket = $sub_row[0];
				}
				
			//sla
		
				$sla_sql="SELECT count(isoverdue) FROM isost_ticket where topic_id=0 and isoverdue=1 and status='open'  and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";				
				$sla_result = mysql_query($sla_sql);				
				$sla_breached='';
				while($sub_row = mysql_fetch_array($sla_result)){				
					$sla_breached= $sub_row[0];
				}
			
			// Fetch the recordset to calculate average closure time
			$sub_sql="SELECT ticket_id,UNIX_TIMESTAMP(created),UNIX_TIMESTAMP(closed) from isost_ticket where topic_id='0' and status like '$status'  and track_id!=999999 and closed IS NOT NULL and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";
				
			$sub_result = mysql_query($sub_sql);
			
			$record_count=mysql_num_rows($sub_result);
			
			$total_close_time	=0;
			$total_response_time=0;
			$time_spent			=0;
			
			while ($sub_row = mysql_fetch_row($sub_result)){
				$ticket_id		=$sub_row[0];
				$created		=$sub_row[1];
				$closed			=$sub_row[2];	
			
				$close_time			=($closed-$created)/3600;
				$total_close_time	=$total_close_time + $close_time;
				
				// Fetch information for Response Time
					
					$sub_sql_1		="SELECT UNIX_TIMESTAMP(created) from isost_ticket_response where ticket_id='$ticket_id'  and track_id!=999999 and UNIX_TIMESTAMP(created) > $created  order by response_id LIMIT 1";
					$sub_result_1 	= mysql_query($sub_sql_1);
					
					if(mysql_num_rows($sub_result_1)>0){
						$sub_row_1 = mysql_fetch_row($sub_result_1);
						$first_response	=$sub_row_1[0];
									
						$response_time=($first_response-$created)/3600;
						$total_response_time	=$total_response_time + $response_time;
					}
					
				// Get Total Time Spent on Responses
				$ts_sql		="select SUM(time_spent) from isost_ticket_response where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
				$ts_result  = mysql_query($ts_sql);
				$ts_row 	= mysql_fetch_row($ts_result);
				$time_spent	= $time_spent + round($ts_row[0],1);
					
				// Get Total Time Spent on Internal Notes
				$ts_sql		="select SUM(time_spent) from isost_ticket_note where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
				$ts_result  = mysql_query($ts_sql);
				$ts_row 	= mysql_fetch_row($ts_result);
				$time_spent	= $time_spent + round($ts_row[0],1);
				
			}
			// Compute Average Closure Time
			$avg_closure=round($total_close_time/$record_count,1);	
				
			// Compute Average Response Time
			$avg_response=round($total_response_time/$record_count,1);
			
			// Fetch the recordset to calculate total time spent
			$sub_sql="SELECT ticket_id from isost_ticket where topic_id='0' and track_id!=999999 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date";
			$sub_result = mysql_query($sub_sql);
			$time_spent			=0;
				
			while ($sub_row = mysql_fetch_row($sub_result)){
					$ticket_id		=$sub_row[0];
				
					// Get Total Time Spent on Responses
					$ts_sql		="select SUM(time_spent) from isost_ticket_response where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
					$ts_result  = mysql_query($ts_sql);
					$ts_row 	= mysql_fetch_row($ts_result);
					$time_spent	= $time_spent + round($ts_row[0],1);
					
					// Get Total Time Spent on Internal Notes
					$ts_sql		="select SUM(time_spent) from isost_ticket_note where ticket_id='$ticket_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
					$ts_result  = mysql_query($ts_sql);
					$ts_row 	= mysql_fetch_row($ts_result);
					$time_spent	= $time_spent + round($ts_row[0],1);
			}
			
						
			echo "<helptopic>";
				echo "<topic>Uncategorized</topic>";
				echo "<topic_id>0</topic_id>";
				echo "<count>".$count."</count>";
				echo "<avg_response>".$avg_response."</avg_response>";
				echo "<avg_closure>".$avg_closure."</avg_closure>";
				echo "<open_ticket>".$open_ticket."</open_ticket>"; 
				echo "<sla_breached>".$sla_breached."</sla_breached>"; 
				echo "<time_spent>".$time_spent."</time_spent>";
			echo "</helptopic>";

			echo "</node>";
		}else{
			$nodata = 0;
			success($nodata);
		}
}

// include config file, also contains the API KEY
require_once('../include/config.php');
require_once('../include/db.php');

$api_key		= strip_tags($_REQUEST['key']);
$status			= strip_tags($_REQUEST['status']);if($status=='all'){$status='%';}
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);
$end_date		+= 86399;

$num_rows		= '';

// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
	$result = mysql_query("SELECT topic_id,topic FROM isost_help_topic order by topic");
	$num_rows = mysql_num_rows($result);
	showxml($result, $num_rows);
}
?>