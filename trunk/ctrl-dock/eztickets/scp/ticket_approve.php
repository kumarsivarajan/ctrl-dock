<?php 
include_once("../../include/config.php");
include_once("../../include/db.php");
include_once("../../include/css/default.css");

$check_email	=$_REQUEST["check_email"];
$check_key		=$_REQUEST["check_key"];
$ticket_id		=$_REQUEST["ticket_id"];
$approval_id	=$_REQUEST["approval_id"];
$action			=$_REQUEST["action"];
$comments		=$_REQUEST["comments"];
$approval_date	=mktime();

$sql		="select ticket_id from isost_ticket_approval where approval_by='$check_email' and approval_key='$check_key' and ticket_id='$ticket_id'";
$result 	= mysql_query($sql);
$result_count=mysql_num_rows($result);


if ($result_count==1){
	$authorized		=1;
}else{
	exit;
}



if(strlen($action)>0){

	$sql="update isost_ticket_approval set approval_status='$action',approval_date='$approval_date',approval_comments='$comments' where approval_id='$approval_id'";
	$result = mysql_query($sql);
	
	$sql="update isost_ticket set pending_approval=0 where ticket_id='$ticket_id'";
	$result = mysql_query($sql);
	
	$sql="select firstname,lastname from user_master where username='$check_email'";
	$result = mysql_query($sql);
	$row=mysql_fetch_row($result);
	$approval_name=$first_name." ".$last_name. " ".$check_email;
	
	$title="Ticket was ".$action." by ".$approval_name;
	$note=$comments;
	
	$sql="insert into isost_ticket_note(ticket_id,staff_id,source,title,note,created)";
	$sql.=" values('$ticket_id','0','system','$title','$note',NOW())";
	$result = mysql_query($sql);
	?>
	<h3>Approval has been submitted.</h3>
	<br><br>
	<h4><a href="javascript:window.close();">CLOSE THIS WINDOW</a></h4>
	<?
}