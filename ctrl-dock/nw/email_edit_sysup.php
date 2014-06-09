<?
/************************************************************************************************
Auth: Aneesh
Created Date: 18/05/2012
Function: Display the Edit page and handle the Update Query
*************************************************************************************************/
include("config.php"); 
if (!check_feature(18)){
	feature_error();
	exit;
}

if($_REQUEST['update']==1){
	$id = $_REQUEST["id"];
	$email_id = $_REQUEST["txt_email"];
	$status = $_REQUEST["select_status"];
	$continuos_alerts= $_REQUEST["continuos_alerts"];

	$update_query = "UPDATE sys_uptime_email SET email_id = '$email_id',status = '$status',continuos_alerts='$continuos_alerts' WHERE id = '$id'";
	mysql_query($update_query);
	print "<center><i><b><font color='#003366' face='Arial' size=2>The Email has been updated successfully.</font></b></i></center>";
    print "<meta http-equiv='Refresh' content='1; URL=index.php'>";
}


$id = $_REQUEST["id"];
$select_query = sprintf("SELECT *
                         FROM sys_uptime_email
                         WHERE id='%s'",$id);
$result = mysql_query($select_query);
$row=mysql_fetch_row($result);

$SELECTED="EDIT TASK";
include("header.php");
?>
<form method="POST" action="email_edit_sysup.php?update=1&id=<?=$id;?>">
<table border=0 cellpadding=3 cellspacing=1 width=100% bgcolor=#F7F7F7>
<tr>
		<td class='tdformlabel'>
		<b>Enter Email Id</b>
		<br>
		<font style="font-weight:normal">
		System alerts will be sent directly to this email ID and not via the ticketing system.
		</td>
		<td align=right><input name="txt_email" size="70" class=forminputtext value="<?=$row[1]?>"></td>
</tr>
<tr>
		<td class='tdformlabel' width=250><b>Continuous Alerts</b>
		<br><font style="font-weight:normal">
		If enabled, alerts will be sent to the email ID, irrespective of whether a ticket is logged on or not.
		</td>
		<td align=right>
		<select name='continuos_alerts' class=formselect>
			<option value='0' <? if($row[5] == '0') { ?> selected <? } ?>>No</option>
			<option value='1' <? if($row[5] == '1') { ?> selected <? } ?>>Yes</option>
		</select>
		</td>
</tr>
<tr>
	<td class='tdformlabel' width=250><b>Email status</b>
		<br><font style="font-weight:normal">
		Is this email ID and setting active in the system.
	</td>	<td align=right>
	<select name='select_status' class=formselect>
	<option value='active' <? if($row[3] == 'active') { ?> selected <? } ?>>Active</option>
	<option value='inactive' <? if($row[3] == 'inactive') { ?> selected <? } ?>>Inactive</option>
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
