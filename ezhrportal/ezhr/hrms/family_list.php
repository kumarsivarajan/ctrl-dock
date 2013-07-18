<?php 
include("config.php"); 
if (!check_feature(12)){feature_error();exit;}


$account=$_REQUEST["account"];

$sql = "select first_name,last_name,account_status from user_master where username='$account'";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);

$first_name		=$row[0];
$last_name		=$row[1];
$account_status	=$row[2];
?>
<center>
<table border=0 cellpadding=3 cellspacing=0 width=100%>
<tr>
	<td align=left>
		<b><font face="Arial" color="#CC0000" size="2">Family Information for : <?=$first_name?> <?=$last_name;?>
	</td>
	<td align=right>
		<a href="user_home.php?account=<?=$account?>"><font face="Arial" color="#336699" size="1"><b>BACK</b></font></a>
	</td>
</tr>
</table>
<br>
<table border=0 width=100% cellspacing=0 cellpadding=3 style="border-collapse: collapse" bordercolor="#E5E5E5">
<tr>
		<td class=reportheader>Member Name</td>
		<td class=reportheader>Relationship</td>
		<td class=reportheader>Date of Birth</td>
		<td class=reportheader>Blood Group</td>
		<td class=reportheader>Dependent</td>
		<td class=reportheader>Comments</td>
		<td class=reportheader colspan=2 width=36></td>
</tr>
<?php
$sql = "select * from user_family_member where username='$account'";
$result = mysql_query($sql);
$i=1;
$row_color="#FFFFFF";
while ($row = mysql_fetch_row($result)){
	if (($i%2)==1){$row_color="#EDEDE4";}else{$row_color="#FFFFFF";}
?>
	<tr bgcolor=<?echo $row_color; ?>>
		<td class=reportdata><? echo $row[1]; ?></td>
		<td class=reportdata><? echo $row[3]; ?></td>
		<td class=reportdata style='text-align:center'><? if (strstr($row[2],'-')==true){echo $row[2];} else { echo date("d-m-Y",$row[2]);} ?></td>
		<td class=reportdata style='text-align:center'><? echo $row[4]; ?></td>
		<td class=reportdata style='text-align:center'><? echo $row[6]; ?></td>
		<td class=reportdata style='text-align:center'><? echo $row[5]; ?></td>
		<td class=reportdata style='text-align:center'><a href="edit_family_information_1.php?account=<? echo $account; ?>&member_name=<? echo $row[1]; ?>"><img border=0 src="images/edit.gif"></a></font></td>
		<td class=reportdata style='text-align:center'><a href="delete_family_information.php?account=<? echo $account; ?>&member_name=<? echo $row[1]; ?>"><img border=0 src="images/delete.gif"></a></font></td>
	</tr>
	<?	
	$i++;
 }
  
  
?>
</table>
<br>
<?
include("add_family_information_1.php"); 
?>
