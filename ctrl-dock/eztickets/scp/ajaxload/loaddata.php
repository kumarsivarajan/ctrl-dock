<?php
sleep(1);
?>

<?php
 
 require('../../../include/config.php');
 

mysql_connect( $DATABASE_SERVER,$DATABASE_USERNAME,$DATABASE_PASSWORD);
mysql_select_db($DATABASE_NAME);

   define('TICKET_TABLE','isost_ticket');
    define('TICKET_NOTE_TABLE','isost_ticket_note');
    define('TICKET_MESSAGE_TABLE','isost_ticket_message');
    define('TICKET_RESPONSE_TABLE','isost_ticket_response');
    define('TICKET_ATTACHMENT_TABLE','isost_ticket_attachment');
    define('TICKET_PRIORITY_TABLE','isost_ticket_priority');
    define('TICKET_LOCK_TABLE','isost_ticket_lock');
    define('TICKET_MSG_TABLE','isost_ticket_message');
    define('TICKET_MRG_TABLE','isost_merge');


 switch($_POST['option']){
	
	case 'mergeTickets':
	
	         $ticket_id=$_POST['ticket_ids'];
			 $track_id=$_POST['track_id'];
             
             $sel="SELECT * FROM ost_merge ORDER BY id";
			 $exe_sel=mysql_query($sel) or die(mysql_error());

            if(mysql_num_rows($exe_sel)==0){
			 
				$ins="INSERT INTO ost_merge(ticket_id,track_id,status) VALUES('$ticket_id',$track_id,'1')";
				$exe_ins=mysql_query($ins) or die(mysql_error());
				$last_id=mysql_insert_id();
			
			}else{
				$ids=''; 
				$i=0;
				while($r=mysql_fetch_array($exe_sel)){
					$ids=$ids.','.$r['track_id'];
				}
				$div_tracks=explode(',',substr($ids,1));
				$count=count($div_tracks); 

				for($i=0;$i<=$count;$i++){
					$arr.array_push($div_tracks[$i]);
					$arr=array($div_tracks);

					if (!in_array($track_id,$arr[$i])) {
						$ins_up="INSERT INTO ost_merge(ticket_id,track_id,status) VALUES('$ticket_id',$track_id,'1')";
						$exe_ins_up=mysql_query($ins_up) or die(mysql_error());
						$last_id=mysql_insert_id();
						echo "Just a moment ..";
						break;
					}
					if(in_array($track_id,$arr[$i])){
						//echo "TrackID Already Merged";
						$up="UPDATE ost_merge SET status='1' WHERE track_id=".$track_id;
						$exe_up=mysql_query($up);
						$msg=($exe_up)?'Just a moment ..':'Matched Track Denied ';
						echo $msg;
						break;
					
					}
				}
			}
	break;
		
	case 'closeTickets':
	//echo $_POST['trackID'];
	
	echo $up="UPDATE ost_ticket SET status='closed',updated=NOW(),closed=NOW(),isoverdue=0 WHERE track_id=".$_POST['trackID'];
	$exe_up=mysql_query($up);
	$msg=($exe_up)?'Just a moment ..':'Matched Track Denied ';
	echo $msg;
	
	break;

	case 'manualTickets':
	
	         $ticket_id=$_POST['ticket_ids'];
			 $pri_track=$_POST['pri_track'];
			  
			 $validate_sql="SELECT status FROM ".TICKET_TABLE." where (track_id=0 or track_id=1) and ticket_id='$pri_track'";
			 $exe_validate=mysql_query($validate_sql);
			 
			 if(mysql_num_rows($exe_validate)>0){
			 
				 $sub_row = mysql_fetch_row($exe_validate);
				 
				 // Fetch Status of the parent ticket
				 $status=$sub_row[0];
			 
				 $sel_exitracks="SELECT ticket_id FROM ".TICKET_MRG_TABLE." WHERE track_id='$pri_track'";
				 $exe_exitracks=mysql_query($sel_exitracks);
				 

				 // If the Parent Merge already exists
			 
				if(mysql_num_rows($exe_exitracks)!=0){
						
						$sub_row = mysql_fetch_row($exe_exitracks);
						$ticket_id.=",".$sub_row[0];
						
						$ticket_id=explode(",",$ticket_id);
						$ticket_id=array_unique($ticket_id);
						$ticket_id=implode(",",$ticket_id);
						
						$sub_sql="update ".TICKET_MRG_TABLE." set status=1,ticket_id='".$ticket_id."' where track_id='$pri_track'";
						$sub_result = mysql_query( $sub_sql );
						
						$up_ticket_tab="UPDATE ".TICKET_TABLE." SET track_id='999999',status='$status' WHERE ticket_id IN ($ticket_id) and ticket_id!=$pri_track";
						$exe_upticket=mysql_query($up_ticket_tab);
					
						?>
						<div style="background-Color:#333;height:15px;padding-top:2px;padding-bottom:2px;color:#ffffff;text-align:right;margin-bottom:10px;padding-right:5px;border-bottom:2px solid #FFCC00;">
						<a href="" ><img src='../images/close.png' border='0' align='absmiddle'></a>
						</div>
						<?php
						echo "Merged into existing ticket successfully.";
				}else {
					$ins="INSERT INTO ".TICKET_MRG_TABLE. "(ticket_id,track_id,status) VALUES('$ticket_id','$pri_track','1')";
					$exe_ins=mysql_query($ins) or die(mysql_error());
					if($exe_ins){
							echo "<div style='height:20px;width:100%;padding-top:10px'>New Merge Created.<div>";

							// Updating the tickets which are merged with a track_id numerical equivalent of "merged"
							$up_ticket_tab="UPDATE ".TICKET_TABLE." SET track_id='999999',status='$status' WHERE ticket_id IN ($ticket_id) ";
							$exe_upticket=mysql_query($up_ticket_tab);
							if($exe_upticket){
								echo "Tickets have been merged successfully.";
							}

						
						   // Updating primary ticket					 
						   $up_pri="UPDATE ".TICKET_TABLE." SET track_id='1' WHERE ticketID=$pri_track ";
						   $exe_pri=mysql_query($up_pri);

					}				
				}
			}else{
				echo "<div style='height:20px;width:100%;padding-top:10px'>The primary ticket entered is in-valid. You cannot merge into a ticket which is already a child of another ticket.";
			}
				
			
     break;
	 
	case 'selectTrack':
	
	$tracks=explode(',',$_POST['ticket_ids']);
     ?>
	 <div style="background-Color:#333;height:16px;padding-top:2px;border-bottom:2px solid #FFCC00;padding-bottom:2px;color:#ffffff;text-align:right;margin-bottom:10px;padding-right:5px;">
	<a href="" ><img src='../images/close.png' border='0' align='absmiddle'></a>
	</div>
	<div>
	Primary Ticket # : <input type=text name="dispTracks" id="dispTracks" style="width:60px;height:20px;">
	<input type="submit" value="Submit" style="width:60px;height:20px;" onclick="javascript:selectBoxval(dispTracks.value);">
	<?php
	break;
 }
 
?>