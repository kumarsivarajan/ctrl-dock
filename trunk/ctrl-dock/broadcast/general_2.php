<? 

include("config.php"); 
include("header.php");

// location to where notice attachments will be uploaded to
$directory = "attachments/";
$target_path = $directory . "temp_". basename( $_FILES['uploadedfile']['name']);

$email_to	=$_REQUEST["email_to"];
$subject	=$_REQUEST["subject"];
$body       =$_REQUEST["body"];
$del_file   =$_REQUEST["del_file"];

if(strlen($del_file)>0){unlink($del_file);}

$disp_body="<p align=left><font face=Arial size=2 color=black>".$body;
$disp_body=nl2br($disp_body);

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
				<font face=Arial size=1><br><? echo $disp_body; ?></font>
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


