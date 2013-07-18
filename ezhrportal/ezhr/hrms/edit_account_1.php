<?php 
include("config.php");
if (!check_feature(3)){feature_error();exit;}

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status,office_index,contact_address,permanent_address,official_email,personal_email,contact_phone_office,contact_phone_residence,contact_phone_mobile from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name			=$row[0];
$last_name			=$row[1];
$account_status		=$row[2];
$office_index		=$row[3];
$contact_address	=$row[4];
$permanent_address	=$row[5];
$official_email		=$row[6];
$personal_email		=$row[7];
$contact_phone_office=$row[8];
$contact_phone_residence=$row[9];
$contact_phone_mobile=$row[10];

?>

<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Contact Information for : <?=$first_name?> <?=$last_name;?></font></b>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>

<?
if ($account_status=="Obsolete"){
	echo "<br><center><font face=Arial size=2 color=#CC0000><b>The account is obsolete. Obsolete accounts should be updated under authorization only.</font></b>";
}
?>

<form method=POST action=edit_account_2.php>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Address</b></td></tr>
<tr>
	<td class=tdformlabel>Office Location</font></b></td>
	<td align=right>
		<select size=1 name=office_index style="font-size: 8pt; font-family: Arial">
			<?php	
			        $sub_sql = "select office_index,country from office_locations";					
					$sub_result = mysql_query($sub_sql);
					while ($sub_row = mysql_fetch_row($sub_result)) {
						if ($office_index==$sub_row[0]){$selected="selected";}else{$selected="";}
			       		echo "<option value='$sub_row[0]' $selected>$sub_row[1] - $sub_row[0]</option>";
					}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class=tdformlabel>Residential Address - Current</font></b></td>
	<td align=right><textarea rows="3" name="contact_address" cols="42" style="font-size: 8pt; font-family: Arial"><?=$contact_address?></textarea></td>
</tr>
<tr>
	<td class=tdformlabel>Residential Address - Permanent</font></b></td>
	<td align=right><textarea rows="3" name="permanent_address" cols="42" style="font-size: 8pt; font-family: Arial"><?=$permanent_address?></textarea></td>
</tr>

<tr>
	<td class=tdformlabel>Official E-Mail</font></b></td>
	<td align=right><input name="official_email" value="<?=$official_email?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Personal E-Mail</font></b></td>
	<td align=right><input name="personal_email" value="<?=$personal_email?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>


<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Contact Details - Phone</b></td></tr>
<tr>
	<td class=tdformlabel>Office</font></b></td>
	<td align=right><input name="contact_phone_office" value="<?=$contact_phone_office?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Residence</font></b></td>
	<td align=right><input name="contact_phone_residence" value="<?=$contact_phone_residence?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Mobile</font></b></td>
	<td align=right><input name="contact_phone_mobile" value="<?=$contact_phone_mobile?>" size="40" style="font-size: 8pt; font-family: Arial"></td>
</tr>


<input name="account" size=40 type=hidden value="<?=$account;?>">

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Information" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>

