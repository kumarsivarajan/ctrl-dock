<?php
include ("../../include/config.php");
include ("../../include/db.php");
include ("../../include/poa_rca.php");
include ("../../include/css/default.css");

$ticket_id		=$_REQUEST['ticket_id'];
$requested_by	=$_REQUEST['requested_by'];
?>
<body leftmargin=0 topmargin=0 bgcolor=#FFFF99>
<form method=POST action="req_ticket_approval_2.php">
<input type=hidden name=ticket_id value="<?=$ticket_id?>">
<input type=hidden name=requested_by value="<?=$requested_by?>">
<input type=hidden name=authenticated value="1">
<table border=0 width=100%>
	<tr>
		<td height=25 class=reportheader>REQUEST APPROVAL FOR TICKET ID : # <?=$ticket_id;?></td>
	</tr>
	<tr>
		<td height=25 align=center><font class=reportdata><b><br>APPROVER'S EMAIL ID<br></b></font></td>
	</tr>
	<tr>
		<td height=25 align=center>
		<input type="text" class='forminputtext' name="approver" size="50" value="">

		</td>
	</tr>
	<tr>
		<td width=500 align=center><input type=submit value="Request Approval" name="Submit" class=forminputbutton></td>
	</tr>
		</form>
</tr>	
</table>
<br>
<h4>An email will be sent to the chosen approver for approval and the ticket will be put in a 'Pending Approval' state.</h4>
</br>
</body>
