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
$continuos_alerts= $_REQUEST["continuos_alerts"];
$created_time = date('Y-m-d H:i:s');

if ($email_id == "" || $email_status == ""){
	
	$SELECTED="HOST UP E-MAIL NOTIFICATION : ".$hostname;
	
	include("header.php");
	?>
	<form method="POST" action="email_add_sysup.php">
	<input type="hidden" name="hidden_host_id" value="<?php echo $host_id?>">
	<table border=0 cellpadding=3 cellspacing=1 width=1000 bgcolor=#F7F7F7>
	<tr>
		<td class='tdformlabel'>
		<b>Enter Email Id</b>
		<br>
		<font style="font-weight:normal">
		System alerts will be sent directly to this email ID and not via the ticketing system.
		</td>
		<td align=right><input name="txt_email" size="70" class=forminputtext></td>
	</tr>
	<tr>
		<td class='tdformlabel' width=250><b>Continuous Alerts</b>
		<br><font style="font-weight:normal">
		If enabled, alerts will be sent to the email ID, irrespective of whether a ticket is logged on or not.
		</td>
		<td align=right>
		<select name='continuos_alerts' class=formselect>
			<option value='0'>No</option>
			<option value='1'>Yes</option>
		</select>
		</td>
	</tr>
	<tr>
		<td class='tdformlabel' width=250><b>Email status</b>
		<br><font style="font-weight:normal">
		Is this email ID and setting active in the system.
		</td>
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
	$insert_query = "INSERT INTO sys_uptime_email (email_id,status,created,host_id,continuos_alerts) VALUES ('$email_id','$email_status','$created_time','$hidden_host_id','$continuos_alerts')";
	mysql_query($insert_query);
?>
	<center><i><b><font color="#003366" face="Arial" size=2>The new Email has been successfully created.</font></b></i></center>
	<meta http-equiv="Refresh" content="1; URL=index.php">
<?	
}
?>

