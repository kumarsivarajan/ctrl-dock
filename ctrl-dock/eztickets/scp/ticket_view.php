<?php 
include_once("../../include/config.php");
include_once("../../include/db.php");
include_once("../../include/css/default.css");

$check_email	=$_REQUEST["check_email"];
$check_key		=$_REQUEST["check_key"];
$ticket_id		=$_REQUEST["ticket_id"];

$sql		="select approval_id from isost_ticket_approval where approval_by='$check_email' and approval_key='$check_key' and ticket_id='$ticket_id'";
$result 	= mysql_query($sql);
$row = mysql_fetch_row($result);
$result_count=mysql_num_rows($result);


if ($result_count==1){
	$authorized		=1;
	$approval_id	=$row[0];
}else{
	exit;
}
?>
<center>
<form method=POST action='ticket_approve.php'>
<input type=hidden name=approval_id value='<?=$approval_id;?>'>
<input type=hidden name=check_email value='<?=$check_email;?>'>
<input type=hidden name=check_key value='<?=$check_key;?>'>
<input type=hidden name=ticket_id value='<?=$ticket_id;?>'>

	<table border=1 width=1000 cellspacing=0 cellpadding=2 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#CCCCFF>
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
<?include_once("ticket.php");?>
