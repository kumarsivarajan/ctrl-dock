<?php 
include_once("../include/config.php");
include_once("../include/db.php");
include_once("../include/poa_rca.php");
include_once("../include/mail_helper.php");
include_once("../include/mail.php");
include_once("../include/css/default.css");
include_once("../include/ticket_post.php");

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."pa";

$check_email	=$_REQUEST["check_email"];
$check_key		=$_REQUEST["check_key"];

$sql="select a.activity_id,a.approver_name,b.action_date from poa_approval_history a,poa_master b ";
$sql.="where a.approver_email='$check_email' and a.approver_key='$check_key' and a.activity_id=b.activity_id";
$result 	= mysql_query($sql);
$result_count=mysql_num_rows($result);

if ($result_count==1){
	$row = mysql_fetch_row($result);
	$activity_id	=$row[0];
	$approver_name	=$row[1];
	$submit_date	=$row[2];
	$poa_display	=$activity_id;
	$authorized		=1;
}else{
	$authorized		=0;
}


if($authorized==1 && $_REQUEST["activity"]=="add"){
	
	$action					=$_REQUEST["action"];

	if(strlen($action)>0){
		$comments				=$_REQUEST["comments"];
		$action_by				=$check_email;	
		$approver_email			=$check_email;	
		$approver_key			=$check_key;	
		$action_date			=mktime();
		
		$sql="update poa_approval_history set action='$action', action_date='$action_date', action_by='$action_by',comments='$comments' where activity_id='$activity_id' and action='PENDING APPROVAL'";
		$result = mysql_query($sql);
		
		echo "<h2>You have submitted your approval. You can close this browser window.</h2>";
			
		if($action=="APPROVED"){
		
			// Check if additional approvals are required and if yes, notify the next user in the approval chain
			$sql="select record_index,approver_name,approver_email,approver_key";
			$sql.=" from poa_approval_history where activity_id='$activity_id' and action in ('ADDED') order by item_order asc limit 1";
			$result = mysql_query($sql);
				
			if(mysql_num_rows($result)>0){

				$row= mysql_fetch_row($result);
						
					$record_index			=$row[0];
					$next_approver_name		=$row[1];
					$next_approver_email	=$row[2];
					$next_approver_key		=random_key();
		
					$sql="update poa_approval_history set approver_key='$next_approver_key',action='PENDING APPROVAL' where record_index='$record_index'";
					$result = mysql_query($sql);
					
					$subject="PLANNED ACTIVITY APPROVAL REQUEST : $poa_display";
					$url=$base_url."/pa_view.php"."?check_email=".$next_approver_email."&check_key="."$next_approver_key";
					$body="\nA Planned Activity is pending your approval. Kindly click on the URL : $url to view and approve the request.\n\n\n";
					$body.="PLEASE NOTE THAT THE ABOVE URL IS FOR ONE TIME USE ONLY.\nPLEASE DO NOT REPLY TO THIS E-MAIL";
					
					ezmail($next_approver_email,$next_approver_name,$subject,$body,"");
					$i++;
				}else{
					// set flag for completed approvals
					$approvals_completed=1;
				}
			
			
			// Notify the owner of the POA
			 
			$subject="PLANNED ACTIVITY : $approver_name $action";
			$body="\nThis is to inform you that, $approver_name has $action the Planned Activity with ID : $poa_display submitted by you.\n\nThe Planned Activity may require further approvals and you shall be notified accordingly.\n\n\n";
			$body.="PLEASE DO NOT REPLY TO THIS E-MAIL";

			if($approvals_completed==1){
				echo "<h3>All approvals have been completed.</h3>";

				$sql="update poa_master set action='APPROVED' where activity_id='$activity_id'";		
				$result = mysql_query($sql);
				
				$subject="PLANNED ACTIVITY $poa_display : $approver_name $action";
				$body="\nThis is to inform you that, $approver_name has $action the Planned Activity with ID : $poa_display submitted by you.\n\nThe Planned Activity does not require any further approvals and now stands completely approved.\n\n\n";
				$body.="PLEASE DO NOT REPLY TO THIS E-MAIL";


				// Raise a ticket
				$subject        = "Planned Activity : ".$poa_display;
				$url=$base_url."/pa_view.php"."?activity_id=".$activity_id;
				$message="\nA Planned Activity has been approved. Kindly click on the URL : $url to view and process the same.\n\n\n";
				ticket_post($smtp_email,$smtp_email,"29","$subject","$message",'3');
				
			}
			

			// Fetch the Owner Information
			$sql="SELECT first_name,last_name,official_email FROM user_master a,poa_master b WHERE b.action_by=a.username and b.activity_id='$activity_id'";
			$result = mysql_query($sql);
			$row= mysql_fetch_row($result);
			$full_name      =$row[0]." ".$row[1];
			$email          =$row[2];

			// Send Notification
			ezmail($email,$full_name,$subject,$body,"");
		}
		
		
		if($action=="REJECTED"){
		
			// Notify the Owner of the POA
			
			$subject="PLANNED ACTIVITY $poa_display : $approver_name $action";	
			$body="\nThis is to inform you that, $approver_name has $action the Planned Activity with ID : $poa_display submitted by you.\n\nThe Planned Activity will not be processed further. Kindly get in touch with $approver_name for more information and re-submit the request.\n\n\n";
			$body.="PLEASE DO NOT REPLY TO THIS E-MAIL";
			
			// Fetch the Owner Information 
			$sql="SELECT first_name,last_name,official_email FROM user_master a,poa_master b WHERE b.action_by=a.username and b.activity_id='$activity_id'";	
			$result = mysql_query($sql);
			$row= mysql_fetch_row($result);
			$full_name	=$row[0]." ".$row[1];
			$email		=$row[2];
			
			// Send Notification
			ezmail($email,$full_name,$subject,$body,"");
			
			
			$sql="update poa_master set action='REJECTED' where activity_id='$activity_id'";
			$result = mysql_query($sql);
		}
	}else{
               echo "<h2>You did not choose an action. Please hit the back button and re-submit your approval.</h2>";

	}
}



if($authorized==1 && !isset($_REQUEST["action"]) && !isset($_REQUEST["comments"])){
?>
<center>
<form method=POST action='pa_approve.php?check_email=<?=$check_email;?>&check_key=<?=$check_key?>&activity=add'>
<table border=1 width=100% cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor="#CCCCFF">
<tr>
	<td class=reportdata style='text-align:left' width=200>Approve this request</td>	

	<td align=left>
		<select size=1 name=action class=formselect>
			<option value=''></option>
			<option value='APPROVED'>APPROVED</option>
			<option value='REJECTED'>REJECTED</option>
		</select>
	</td>
</tr>
<tr>
	<td class=reportdata style='text-align:left' width=200>Comments / Feedback</td>	
	<td align=center><textarea rows="5" name="comments" class=formtextarea style="width:100%"></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<input type=submit value="Submit Your Approval / Rejection with Comments" name="Submit" class=forminputtext>
	</td>
</tr>
</table>
</form>
</center>
<br>
<?
}

?>
