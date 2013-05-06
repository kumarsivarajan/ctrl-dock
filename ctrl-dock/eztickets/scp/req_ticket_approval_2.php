<script language="JavaScript">
function refreshParent() {
  window.opener.location.href = window.opener.location.href;

  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}

</script>
<?php 
include ("../../include/config.php");
include ("../../include/db.php");
include ("../../include/poa_rca.php");
include ("../../include/mail_helper.php");
include ("../../include/mail.php");
include ("../../include/css/default.css");

$authenticated			=$_REQUEST['authenticated'];
$ticket_id				=$_REQUEST['ticket_id'];
$request_date			=mktime();
$requested_by			=$_REQUEST['requested_by'];
$approval_by			=$_REQUEST["approver"];
$approval_key			=random_key();

$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME."eztickets/scp";


if ($authenticated==1){
	$sql="insert into isost_ticket_approval (ticket_id,request_date,requested_by,approval_status,approval_by,approval_date,approval_comments,approval_key)";
	$sql.=" values('$ticket_id','$request_date','$requested_by','PENDING','$approval_by','','','$approval_key')";
	$result = mysql_query($sql);
	
	$sql="update isost_ticket set pending_approval=1 where ticket_id='$ticket_id'";
	$result = mysql_query($sql);
	
	$title="Ticket Pending Approval";
	$note="Ticket is pending external approval from ".$approval_name." requested by ".$requested_by;
	
	$sql="insert into isost_ticket_note(ticket_id,staff_id,source,title,note,created)";
	$sql.=" values('$ticket_id','0','system','$title','$note',NOW())";
	$result = mysql_query($sql);
	
	
	$subject="TICKET APPROVAL REQUEST : # $ticket_id";
	$url=$base_url."/ticket_view.php"."?check_email=".$approval_by."&check_key="."$approval_key"."&ticket_id=".$ticket_id;
	$body="\nA ticket is pending your approval. Kindly click on the URL : $url to view and approve the request.\n\n\n";
	$body.="PLEASE NOTE THAT THE ABOVE URL IS FOR ONE TIME USE ONLY. \nPLEASE DO NOT REPLY TO THIS E-MAIL";
	
	ezmail($approval_by,$approval_by,$subject,$body,"");
	
?>
	<h3>Approval Request has been sent</h3>
	<br><br>
	<h4><a href="javascript:refreshParent();">CLOSE THIS WINDOW</a></h4>
<?
}
?>

