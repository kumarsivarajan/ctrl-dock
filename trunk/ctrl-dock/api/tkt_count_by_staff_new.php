<?php

header('Content-Type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

// This API is used to count the number of tickets based on the staff who have been assigned to address the issue
// ticket_count_by_staff.php?key=abcd
// Possible Values are 
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
				$staff_name=$row[1];
				$staff_id = $row[0];		
				
				$staff_sql = "select first_name, last_name, official_email from user_master where username='$staff_name'";
				$staff_result = mysql_query($staff_sql);
				$staff_result = mysql_fetch_row($staff_result);
				$firstname 			= $staff_result[0];
				$lastname 			= $staff_result[1];
				$official_email		= $staff_result[2];
				// Start New section to display the close details
				$local = "locally";
				$remote = "remotely";
                                $sub_sql=sprintf("SELECT count(ticket_id) 
						  FROM isost_ticket 
						  WHERE UNIX_TIMESTAMP(created) >= %d and UNIX_TIMESTAMP(created) <= %d 
						  and track_id!=999999 and staff_id = %d and status=2 and close_tkt_location = '%s'",$start_date,$end_date,$staff_id,$local);
                                $sub_result = mysql_query($sub_sql);
                                $sub_result = mysql_fetch_row($sub_result);
                                $close_locally_count = $sub_result[0];
				$sub_sql=sprintf("SELECT count(ticket_id)
                                                  FROM isost_ticket
                                                  WHERE UNIX_TIMESTAMP(created) >= %d and UNIX_TIMESTAMP(created) <= %d
                                                  and track_id!=999999 and staff_id = %d and status=2 and close_tkt_location = '%s'",$start_date,$end_date,$staff_id,$remote);
	
                                $sub_result = mysql_query($sub_sql);
                                $sub_result = mysql_fetch_row($sub_result);
                                $close_remote_count = $sub_result[0];
				//End
				/*
				//Closed Tickets
				$sub_sql="SELECT count(a.ticket_id) FROM isost_ticket_note WHERE UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and staff_id = $staff_id and title='Ticket status changed to Closed'";
				$sub_result = mysql_query($sub_sql);
				$sub_result = mysql_fetch_row($sub_result);
				$closed_count = $sub_result[0];
				*/
				//Open Tickets
				$sub_sql="SELECT count(ticket_id) FROM isost_ticket WHERE UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and track_id!=999999 and staff_id = $staff_id and status=1";
				$sub_result = mysql_query($sub_sql);
				$sub_result = mysql_fetch_row($sub_result);
				$open_count = $sub_result[0];				
				
				// Fetch the recordset to calculate average closure time
				$sub_sql="SELECT a.ticket_id,UNIX_TIMESTAMP(a.created),UNIX_TIMESTAMP(a.closed) from isost_ticket a where a.status=2 and track_id!=999999 and UNIX_TIMESTAMP(a.created) >= $start_date and UNIX_TIMESTAMP(a.created) <= $end_date and a.staff_id = $staff_id";
				
				$sub_result = mysql_query($sub_sql);
				$record_count=mysql_num_rows($sub_result);
				$closed_count=$record_count;
				
				$total_close_time	=0;
				$total_response_time=0;
				
				while ($sub_row = mysql_fetch_row($sub_result)){
					$ticket_id		=$sub_row[0];
					$created		=$sub_row[1];
					$closed			=$sub_row[2];	
				
					$close_time			=($closed-$created)/3600;
					$total_close_time	=$total_close_time + $close_time;
					
					// Fetch information for Response Time
					
					$sub_sql_1		="SELECT UNIX_TIMESTAMP(created) from isost_ticket_response where ticket_id='$ticket_id' and track_id!=999999 and UNIX_TIMESTAMP(created) > $created  order by response_id LIMIT 1";
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
				
				$total_count = $open_count + $closed_count;
				
				// SLA Breached Count
				//$sla_sql="SELECT count(a.isoverdue) FROM isost_ticket a, isost_ticket_note b where a.isoverdue=1 and a.status=1 and UNIX_TIMESTAMP(a.created) >= $start_date and UNIX_TIMESTAMP(a.created) <= $end_date and a.ticket_id=b.ticket_id and b.staff_id = $staff_id";				
				$sla_sql="SELECT count(isoverdue) FROM isost_ticket where isoverdue=1 and track_id!=999999 and status=1 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and staff_id = $staff_id";
				$sla_result = mysql_query($sla_sql);				
				$sla_breached='';
				while($sub_row = mysql_fetch_array($sla_result)){				
					$sla_breached= $sub_row[0];
				}
			
				// Get Staff Rating
				$rating_sql		="select AVG(rating) from ticket_rating where rated_staff='$official_email' and rated_date>$start_date and rated_date<$end_date";
				$rating_result  = mysql_query($rating_sql);
				$rating_row 	= mysql_fetch_row($rating_result);
				$rating 		= round($rating_row[0],1);
				
				// Get Time spent on Ticket
				// Check Internal Notes
				$ts_sql		="select SUM(time_spent) from isost_ticket_note where staff_id='$staff_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
				$ts_result  = mysql_query($ts_sql);
				$ts_row 	= mysql_fetch_row($ts_result);
				$time_spent	= round($ts_row[0],1);
				
				// Check Response
				$ts_sql		="select SUM(time_spent) from isost_ticket_response where staff_id='$staff_id' and UNIX_TIMESTAMP(created)>$start_date and UNIX_TIMESTAMP(created)<$end_date";
				$ts_result  = mysql_query($ts_sql);
				$ts_row 	= mysql_fetch_row($ts_result);
				$time_spent	= $time_spent + round($ts_row[0],1);
			
			
				echo "<ticketcount>";
					echo "<staff>".$firstname. " " . $lastname ."</staff>";
					echo "<open_count>".$open_count."</open_count>";
					echo "<close_locally_count>".$close_locally_count."</close_locally_count>";
					echo "<close_remote_count>".$close_remote_count."</close_remote_count>";
					echo "<closed_count>".$closed_count."</closed_count>";
					echo "<total_count>".$total_count."</total_count>";
					echo "<avg_response_time>".$avg_response."</avg_response_time>";
					echo "<avg_closure_time>".$avg_closure."</avg_closure_time>";
					echo "<sla_breached_count>".$sla_breached."</sla_breached_count>";
					echo "<rating>".$rating."</rating>";
					echo "<time_spent>".$time_spent."</time_spent>";
				echo "</ticketcount>";
			}
			// Fetch the count for unassigned tickets
			//Open Tickets
				$sub_sql="SELECT count(ticket_id) FROM isost_ticket WHERE UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and track_id!=999999 and staff_id = 0 and status=1";
				$sub_result = mysql_query($sub_sql);
				$sub_result = mysql_fetch_row($sub_result);
				$open_count = $sub_result[0];				
				
				// Fetch the recordset to calculate average closure time
				$sub_sql="SELECT a.ticket_id,UNIX_TIMESTAMP(a.created),UNIX_TIMESTAMP(a.closed) from isost_ticket a where a.status=2 and UNIX_TIMESTAMP(a.created) >= $start_date and UNIX_TIMESTAMP(a.created) <= $end_date and track_id!=999999 and a.staff_id = 0";
				
				$sub_result = mysql_query($sub_sql);
				$record_count=mysql_num_rows($sub_result);
				$closed_count=$record_count;
				
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
				
				$total_count = $open_count + $closed_count;
				
				// SLA Breached Count
				//$sla_sql="SELECT count(a.isoverdue) FROM isost_ticket a, isost_ticket_note b where a.isoverdue=1 and a.status=1 and UNIX_TIMESTAMP(a.created) >= $start_date and UNIX_TIMESTAMP(a.created) <= $end_date and a.ticket_id=b.ticket_id and b.staff_id = 0";				
				$sla_sql="SELECT count(isoverdue) FROM isost_ticket where isoverdue=1 and status=1 and UNIX_TIMESTAMP(created) >= $start_date and UNIX_TIMESTAMP(created) <= $end_date and track_id!=999999 and staff_id = 0";
				$sla_result = mysql_query($sla_sql);				
				$sla_breached='';
				while($sub_row = mysql_fetch_array($sla_result)){				
					$sla_breached= $sub_row[0];
				}
				
								
				
			echo "<ticketcount>";
				echo "<staff>Unassigned</staff>";
				echo "<open_count>".$open_count."</open_count>";
				echo "<closed_count>".$closed_count."</closed_count>";
				echo "<total_count>".$total_count."</total_count>";
				echo "<avg_response_time>".$avg_response."</avg_response_time>";
				echo "<avg_closure_time>".$avg_closure."</avg_closure_time>";
				echo "<sla_breached_count>".$sla_breached."</sla_breached_count>";
			echo "</ticketcount>";
			/*
			echo "<ticketcount>";
				echo "<staff>Unassigned</staff>";
				echo "<open_count>".$open_count."</open_count>";
				echo "<closed_count>".$closed_count."</closed_count>";
				echo "<total_count>".$total_count."</total_count>";
				echo "<avg_response_time>".$avg_response."</avg_response_time>";
				echo "<avg_closure_time>".$avg_closure."</avg_closure_time>";
				echo "<sla_breached_count>".$sla_breached."</sla_breached_count>";
			echo "</ticketcount>";
			*/
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
$start_date		= strip_tags($_REQUEST['start_date']);
$end_date		= strip_tags($_REQUEST['end_date']);
$end_date		+= 86399;

$num_rows		= '';
// validate api key
if($api_key!=$API_KEY || $api_key==''){
	invalid();
}else{
		$sql = "select distinct a.staff_id,b.username from isost_ticket a, isost_staff b where a.track_id!=999999 and UNIX_TIMESTAMP(a.created) >= $start_date and UNIX_TIMESTAMP(a.created) <= $end_date and b.username != 'administrator' and a.staff_id=b.staff_id";
		$result = mysql_query($sql);		
		$num_rows = mysql_num_rows($result);
		showxml($result, $num_rows);
}
?>
