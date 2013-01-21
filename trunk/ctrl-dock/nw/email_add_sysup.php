<?
/*******************************************************************************************************
Auth: Aneesh
Creation Date: 18/05/2012
Function: Display the UI for adding an email and query to insert the details to DB
*******************************************************************************************************/
include("config.php"); 
if (!check_feature(17)){
	feature_error();
	exit;
}

$host_id = $_REQUEST["host_id"];
$hostname	=$_REQUEST["hostname"];

$hidden_host_id = $_REQUEST["hidden_host_id"];
$email_id = $_REQUEST["txt_email"];
$email_status = $_REQUEST["select_status"];
$created_time = date('Y-m-d H:i:s');

if ($email_id == "" || $email_status == ""){
	
	$SELECTED="HOST UP E-MAIL NOTIFICATION : ".$hostname;
	
	include("header.php");
	?>
	<form method="POST" action="email_add_sysup.php">
	<input type="hidden" name="hidden_host_id" value="<?php echo $host_id?>">
	<table border=0 cellpadding=1 cellspacing=1 width=1000 bgcolor=#F7F7F7>
	<tr>
		<td class='tdformlabel'><b>&nbsp;Enter Email Id</font></b></td>
		<td align=right><input name="txt_email" size="70" class=forminputtext></td>
	</tr>
	<tr>
		<td class='tdformlabel' width=250><b>&nbsp;Status</font></b></td>
		<td align=right>
		<select name='select_status' class=formselect>
			<option value='active'>Active</option>
			<option value='inactive'>Inactive</option>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class=forminputbutton>&nbsp;&nbsp;
		<input type="button" onclick="window.location=''" value="Reset" class=forminputbutton>
		</td>
	</tr>
	</table>
	</form>
	<?php
}else {
	$insert_query = sprintf("INSERT INTO sys_uptime_email (email_id,status,created,host_id) 
			VALUES ('%s','%s','%s',%d)",$email_id,$email_status,$created_time,$hidden_host_id);
	mysql_query($insert_query);
?>
	<center><i><b><font color="#003366" face="Arial" size=2>The new Email has been successfully created.</font></b></i></center>
	<meta http-equiv="Refresh" content="1; URL=index.php">
<?	
}
?>

