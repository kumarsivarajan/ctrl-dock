<? 

include("config.php"); 
include("header.php");

// location to where notice attachments will be uploaded to
$directory = "attachments/";
$target_path = $directory . "temp_". basename( $_FILES['uploadedfile']['name']);
$del_file   =$_REQUEST["del_file"];

if(strlen($del_file)>0){unlink($del_file);}

$disp_body="<p align=left><font face='Arial' size='2' color='black'>".$body;

$email_to		=$_REQUEST["email_to"];

$comm_type  	=$_REQUEST["comm_type"];
$service_type   =$_REQUEST["service_type"];
$activity   	=$_REQUEST["activity"];

$activity_type 	=$_REQUEST["activity_type"];
$service_desc 	=$_REQUEST["service_desc"];
$disruption 	=$_REQUEST["disruption"];
$comments 		=$_REQUEST["comments"];
$contact_email  =$_REQUEST["contact_email"];
$contact_phone  =$_REQUEST["contact_phone"];

$from			=$_REQUEST["from_date"]." ".$_REQUEST["from_time_hh"].":".$_REQUEST["from_time_mm"];
$to				=$_REQUEST["to_date"]." ".$_REQUEST["to_time_hh"].":".$_REQUEST["to_time_mm"];

$subject		="IT NOTICE : ". $comm_type . " : " . $service_type . " : ". $activity;
if ($activity_type=="Scheduled"){
	$body="Dear User,<br />Kindly note the following changes to our IT Infrastructure.<br />We request you to kindly read the details and plan your activities accordingly based on the information provided below.<br /><br />";
}
if ($activity_type=="Unscheduled"){
	$body="Dear User,<br />This is to notify you of the following changes to our IT Infrastructure.<br />";
}

$body.="Activity Type : " . $activity_type . "<br />";
$body.="Activity / Incident : " . $activity . "<br /><br />";

$body.="From Date/Time : " . $from . "<br />";
$body.="To Date/Time : " . $to . "<br /><br />";

$body.="Type of Service : " . $service_type . "<br />";
$body.="Description (if any) : " . $service_desc . "<br /><br />";

$body.="Level of Disruption (if any) : " . $disruption . "<br /><br />";
$body.="Comments : " . $comments . "<br /><br />";

$body.="In case of any assistance that you may need at any point in time or need any further information, kindly get in touch with us at $contact_email / $contact_phone";
$body.="Thanks & Regards<br />IT HELPDESK";

$disp_body="<p align=left><font face='Arial' size='2' color='black'>".$body;

?>
<center>
<fieldset style="width: 800px;">
	<form method="POST" action="notice_send.php">
		<input type=hidden name='email_to' value='<? echo $email_to;?>'>
		<input type=hidden name='subject'  value="<? echo htmlspecialchars($subject, ENT_QUOTES);?>">
		<input type=hidden name='body' 	   value="<? echo htmlspecialchars($body, ENT_QUOTES);?>">
		<?php if($target_path != 'attachments/temp_') { ?>
		<input type=hidden name='target_path'  value='<? echo $target_path;?>'>
		<?php } ?>
		<table border="0" width=800>
			<tr>
				<td><label style="width: 150px;">To  : </label></td>
				<td><font face=Arial size=2><? echo $email_to; ?></font></td>
			</tr>
			<tr>
				<td><label style="width: 150px;">Subject  : </label></td>
				<td><font face=Arial size=2><? echo $subject; ?></font></td>
			</tr>
			<tr>
				<td colspan=2>
				<font face=Arial size=1><? echo $disp_body; ?></font>
				</td>
			</tr>
			<tr>				
				<td align="center" colspan=2>
					<input class="forminputbutton" type="submit" value="Confirm" name="Submit">
				</td>
			</tr>
		</table>
	</form>
</fieldset>

<h2>Attachments</h2>
<form enctype="multipart/form-data" method="POST" action="general_2.php">
<fieldset style="width: 800px;">
<input type=hidden name='email_to' value='<? echo $email_to;?>'>
<input type=hidden name='subject'  value="<? echo htmlspecialchars($subject, ENT_QUOTES);?>">
<input type=hidden name='body' 	   value="<? echo htmlspecialchars($body, ENT_QUOTES);?>">

<?
if (basename($_FILES['uploadedfile']['name'])){
	move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);	
	?>
	<input type=hidden name='del_file' value='<? echo $target_path;?>'>
	<?
	
	echo "<font face=Arial size=2>".basename($_FILES['uploadedfile']['name'])."</font>&nbsp;&nbsp;&nbsp;&nbsp;"."<input class=forminputtext type=submit value='Delete Attachment' name=Submit>";
	
}else{
?>
	<font face=Arial size=1><b>Select File <input class=forminputtext name="uploadedfile" type="file" />&nbsp;&nbsp;
	<input class="forminputtext" type="submit" value="Attach File" name="Submit">
<?}?>
</form>
</fieldset>