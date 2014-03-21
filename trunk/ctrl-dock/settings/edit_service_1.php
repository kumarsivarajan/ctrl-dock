<?php 
include("config.php"); 
if (!check_feature(18)){feature_error();exit;}

$service=$_REQUEST["service"];

$sql = "select comments from services where service='$service'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$comments=$row[0];

$sql = "select type,url,port,username,password,domain from service_properties where service='$service'";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
if($count>0){
	$row = mysql_fetch_row($result);
	$service_type	=$row[0];
	$service_url	=$row[1];
	$service_port	=$row[2];
	$service_user	=$row[3];
	$service_pass	=$row[4];
	$service_domain	=$row[5];
}else{
	$sql = "INSERT INTO service_properties VALUES('$service','$service_type','$service_url','$service_port','$service_user','$service_pass','$service_domain')";
	mysql_query($sql);
}
?>

<?
$SELECTED="EDIT SERVICE : ".$service;
include("header.php");
?>

<form method=POST action=edit_service_2.php>
<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#F7F7F7>
	<input name="service" size="40" value="<? echo $service; ?>" type=hidden>
<tr>
	<td class='tdformlabel'><b>&nbsp;Service Display Name</font></b></td>
	<td align=right><input name="comments" size="40" class=forminputtext value='<?echo $comments?>'></td>
</tr>
<br>
<tr>
	<td class='tdformlabel'><b>&nbsp;Service Type</font></b></td>
	<td align=right>
			<select size=1 name=service_type class='formselect'>
			<?php
				echo "<option value='$service_type'>$service_type</option>";
			    $sub_sql = "select * from service_type";
				$sub_result = mysql_query($sub_sql);
				while ($sub_row = mysql_fetch_row($sub_result)) {
		        		echo "<option value='$sub_row[0]'>$sub_row[0]</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td class='tdformlabel' width=250><b>&nbsp;Service URL / IP Address / Hostname</font></b></td>
	<td align=right><input name="service_url" size="40" class=forminputtext value='<?echo $service_url?>'></td>
</tr>
<tr>
	<td class='tdformlabel'><b>&nbsp;Port (if applicable)</font></b></td>
	<td align=right><input name="service_port" size="40" class=forminputtext value='<?echo $service_port;?>'></td>
</tr>

<tr>
	<td class='tdformlabel'><b>&nbsp;Username</font></b></td>
	<td align=right><input name="service_user" size="40" class=forminputtext value='<?echo $service_user;?>'></td>
</tr>

<tr><input type="hidden" name="oldpass" value="<?php print $service_pass; ?>"/>
	<td class='tdformlabel'><b>&nbsp;Password</font></b></td>
	<td align=right><input type="password" name="service_pass" size="40" class=forminputtext></td>
</tr>

<tr>
	<td class='tdformlabel'><b>&nbsp;Domain</font></b></td>
	<td align=right><input name="service_domain" size="40" class=forminputtext value='<?echo $service_domain;?>'></td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Save" name="Submit" class='forminputbutton'>
	</td>
</tr>
</table>
</form>



