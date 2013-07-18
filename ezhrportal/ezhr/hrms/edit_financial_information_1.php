<?php 
include("config.php"); 
if (!check_feature(5)){feature_error();exit;}
include("calendar.php");

$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];

$sql = "select bank,bank_branch,bank_ifsc_code,bank_account,pf_no,esi_no,pan_no from user_financial_information where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$bank=$row[0];
$bank_branch=$row[1];
$bank_ifsc_code=$row[2];
$bank_account=$row[3];
$pf_no=$row[4];
$esi_no=$row[5];	
$pan_no=$row[6];

?>
<center>

<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Edit Financial Information for : <?=$first_name?> <?=$last_name;?></font></b>
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

<form method=POST action=edit_financial_information_2.php>
<input type=hidden name=account value="<?=$account;?>">
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Bank Information</b></td></tr>
<tr>
	<td class=tdformlabel>Bank</font></b></td>
	<td align=right><input name="bank"  value="<?=$bank?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Bank Branch</font></b></td>
	<td align=right><input name="bank_branch"  value="<?=$bank_branch?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Bank IFSC Code</font></b></td>
	<td align=right><input name="bank_ifsc_code"  value="<?=$bank_ifsc_code?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>
<tr>
	<td class=tdformlabel>Bank Account</font></b></td>
	<td align=right><input name="bank_account"  value="<?=$bank_account?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Permanent Account Number </b></td></tr>

<tr>
	<td class=tdformlabel>PAN No.</font></b></td>
	<td align=right><input name="pan_no"  value="<?=$pan_no?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr><td bgcolor=#666666 colspan=2><font face=Arial size=2 color=White><b>&nbsp;Benefits</b></td></tr>

<tr>
	<td class=tdformlabel>PF No.</font></b></td>
	<td align=right><input name="pf_no"  value="<?=$pf_no?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td class=tdformlabel>ESI No.</font></b></td>
	<td align=right><input name="esi_no"  value="<?=$esi_no?>" size="42" style="font-size: 8pt; font-family: Arial"></td>
</tr>

<tr>
	<td colspan=2 align=center>
		<br><input type=submit value="Update Information" name="Submit" style="font-size: 8pt; font-family: Arial">
	</td>
</tr>
</form>
</table>
